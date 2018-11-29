<?php

namespace Apiate;

class RouteCollection
{
    /**
     * @var Route[]
     */
    private $routes;

    public function add(Route $route)
    {
        $this->routes[] = $route;
    }
}