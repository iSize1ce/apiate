<?php

namespace Apiate;

use Apiate\HTTP\{Request, Response};
use Apiate\Route\{Route, RouteCollection, RouteProvider};

class Apiate
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routes;

    /**
     * @var \Closure[]
     */
    private $beforeMiddleware = [];

    /**
     * @var \Closure[]
     */
    private $afterMiddleware = [];

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function getRoutes(): RouteProvider
    {
        return new RouteProvider('', $this->routes);
    }

    public function handle(Request $request): void
    {
        foreach ($this->beforeMiddleware as $before) {
            $responseFromBefore = $before($request);

            if ($responseFromBefore instanceof Response) {
                $this->sendResponse($responseFromBefore);

                return;
            }
        }

        $matchedRoute = $this->matchRoute($request);

        if ($matchedRoute === null) {
            throw new RouteNotFoundException();
        }

        $response = $matchedRoute->getHandler()->handle($request);

        foreach ($this->afterMiddleware as $after) {
            $responseFromAfter = $after($request, $response);

            if ($responseFromAfter instanceof Response) {
                $this->sendResponse($responseFromAfter);

                return;
            }
        }

        $this->sendResponse($response);
    }

    private function matchRoute(Request $request): ?Route
    {
        $requestPath = $request->getUriPath();
        $requestMethod = $request->getMethod();

        $matchedRoute = null;
        foreach ($this->routes as $route) {
            if ($route->getMethod() !== $requestMethod) {
                continue;
            }

            $routePath = $route->getPath();

            $routePathRegex = preg_replace('/{([a-z]+)}/Ui', '(?<$1>.*)', $routePath);
            $routePathRegex = preg_replace('/{([a-z]+)=(.*)}/Ui', '(?<$1>$2)', $routePathRegex);
            $routePathRegex = str_replace('/', '\/', $routePathRegex);

            if (preg_match_all('/^' . $routePathRegex . '$/Ui', $requestPath, $matches) === 1) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $request->getUriParameters()->offsetSet($key, $match[0]);
                    }
                }

                return $route;
            }
        }

        return null;
    }

    public function before(\Closure $closure, ?int $weight = null)
    {
        $this->beforeMiddleware[$weight] = $closure;

        return $this;
    }

    public function after(\Closure $closure, ?int $weight = null)
    {
        $this->afterMiddleware[$weight] = $closure;

        return $this;
    }

    public function sendResponse(Response $response, ?Request $request = null)
    {
        $response->send();
    }
}