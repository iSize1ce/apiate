<?php

namespace Apiate;

use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Apiate\Route\RouteProvider;
use Apiate\RouteMatcher\DefaultRouteMatcher;
use Apiate\RouteMatcher\RouteMatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class Apiate
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routes;

    /**
     * @var \Closure[]
     */
    private $beforeMiddleware;

    /**
     * @var \Closure[]
     */
    private $afterMiddleware;

    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    public function __construct(?RouteMatcherInterface $routeMatcher)
    {
        $this->routes = new RouteCollection();

        $this->routeMatcher = $routeMatcher ?? new DefaultRouteMatcher($this->routes);
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

        $matchedRoute = $this->routeMatcher->getRouteByRequest($request);

        if (!$matchedRoute) {
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
        if ($request !== null) {
            $response->prepare($request);
        }

        $response->send();
    }
}