<?php

namespace Apiate\RouteHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerRouteHandler implements RouteHandlerInterface
{
    private $controllerObject;

    /**
     * @var string
     */
    private $method;

    public function __construct($controllerObject, string $method)
    {
        $this->controllerObject = $controllerObject;
        $this->method = $method;
    }

    public function handle(Request $request): Response
    {
        return $this->controllerObject->{$this->method}($request);
    }
}