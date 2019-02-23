<?php

namespace Apiate\Route;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class RouteCollection implements IteratorAggregate
{
    /**
     * @var Route[]
     */
    private $routes;

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->routes);
    }
}