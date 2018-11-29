<?php

namespace Apiate;

class RouteProvider
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var RouteCollection
     */
    private $routes;

    public function __construct(string $path, RouteCollection $routes)
    {
        $this->path = $path;
        $this->routes = $routes;
    }

    public function createNamespace(string $pathPart, \Closure $closure): void
    {
        $routeProvider = new RouteProvider($this->path . $pathPart, $this->routes);
        $closure($routeProvider);
    }

    public function get(string $path, HandlerInterface $handler)
    {
        $this->createRoute('GET', $this->path . $path, $handler);
    }

    public function post(string $path, HandlerInterface $handler)
    {
        $this->createRoute('POST', $this->path . $path, $handler);
    }

    private function createRoute(string $method, string $path, HandlerInterface $handler)
    {
        $this->routes->add(
            new Route($method, $path, $handler)
        );
    }
}