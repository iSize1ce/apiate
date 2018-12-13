<?php

namespace Apiate\Route;

use Apiate\Handler\HandlerInterface;
use Apiate\HTTP\Request;

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

    public function get(string $path, HandlerInterface $handler): void
    {
        $this->handle([Request::METHOD_GET], $path, $handler);
    }

    public function post(string $path, HandlerInterface $handler): void
    {
        $this->handle([Request::METHOD_POST], $path, $handler);
    }

    public function delete(string $path, HandlerInterface $handler): void
    {
        $this->handle([Request::METHOD_DELETE], $path, $handler);
    }

    public function put(string $path, HandlerInterface $handler): void
    {
        $this->handle([Request::METHOD_PUT], $path, $handler);
    }

    /**
     * @param string[] $methods
     */
    public function handle(array $methods, string $path, HandlerInterface $handler): void
    {
        $this->routes->add(
            new Route($methods, $this->path . $path, $handler)
        );
    }
}