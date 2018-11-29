<?php

namespace Apiate;

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
        foreach ($this->routes as $route) {
            if ($route->getMethod() !== $request->getMethod()) {
                continue;
            }

            $routePath = $route->getPath();

            if (strpos($routePath, '{') === false && strpos($routePath, '}') === false) {
                if ($routePath === $request->getPath()) {
                    $matchedRoute = $route;

                    break;
                }
            } else {
                // TODO
            }
        }

        $response = $matchedRoute->getHandler()->handle($request);
    }
}