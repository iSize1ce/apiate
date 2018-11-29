<?php

namespace Apiate\Route;

use Traversable;

class RouteCollection implements \IteratorAggregate
{
    /**
     * @var Route[]
     */
    private $routes;

    public function add(Route $route)
    {
        $this->routes[] = $route;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->routes);
    }
}