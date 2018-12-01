<?php

namespace Apiate;

use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Apiate\Route\RouteProvider;
use Symfony\Component\HttpFoundation\Request;

class Apiate
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routes;

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
        $matchedRoute = $this->matchRoute($request);

        var_dump($matchedRoute);

        if (!$matchedRoute) {
            throw new \Exception('Route not found');
        }

        $response = $matchedRoute->getHandler()->handle($request);

        $response->prepare($request);
        $response->send();
    }

    private function matchRoute(Request $request)
    {
        $requestPath = $request->getPathInfo();
        $requestMethod = $request->getMethod();

        $matchedRoute = null;
        foreach ($this->routes as $route) {
            if ($route->getMethod() !== $requestMethod) {
                continue;
            }

            $routePath = $route->getPath();

            if (strpos($routePath, '{') === false && strpos($routePath, '}') === false) {
                if ($routePath === $requestPath) {
                    return $route;
                }
            } else {
                $regexPath = preg_replace(['/{[a-z0-9]+}/i', '/{[a-z0-9]+=(.*)}/Ui'], [], $routePath);
                $regexResult = preg_match('/^' . $regexPath . '&/U', $requestPath, $regexMatches);
            }
        }

        return null;
    }
}