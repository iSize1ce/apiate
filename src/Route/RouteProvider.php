<?php

namespace Apiate\Route;

use Psr\Http\Server\RequestHandlerInterface;

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

    public function createNamespace(string $path, \Closure $closure): void
    {
        $routeProvider = new RouteProvider($this->path . $path, $this->routes);
        $closure($routeProvider);
    }

    public function get(string $path, RequestHandlerInterface $handler): void
    {
        // @TODO Use const or delete method
        $this->handle('GET', $path, $handler);
    }

    public function post(string $path, RequestHandlerInterface $handler): void
    {
        // @TODO Use const or delete method
        $this->handle('POST', $path, $handler);
    }

    public function delete(string $path, RequestHandlerInterface $handler): void
    {
        // @TODO Use const or delete method
        $this->handle('DELETE', $path, $handler);
    }

    public function put(string $path, RequestHandlerInterface $handler): void
    {
        // @TODO Use const or delete method
        $this->handle('PUT', $path, $handler);
    }

    public function handle(string $method, string $path, RequestHandlerInterface $handler): void
    {
        $route = new Route($method, $this->path . $path, $handler);

        $this->routes->add($route);
    }
}