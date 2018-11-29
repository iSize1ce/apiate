<?php

namespace Apiate;

class Apiate
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * Apiate constructor.
     */
    public function __construct()
    {
    }

    public function getRoutes(): RouteProvider
    {
        return new RouteProvider('', $this->routes);
    }

    public function handle(Request $request): void
    {

    }
}