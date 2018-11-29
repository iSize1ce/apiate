<?php

namespace Apiate;

class Apiate
{
    /**
     * @var RouteCollection
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

    }
}