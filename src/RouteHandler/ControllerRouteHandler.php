<?php

namespace Apiate\RouteHandler;

use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerRouteHandler implements RouteHandlerInterface
{
    /**
     * @var stdClass
     */
    private $controller;

    /**
     * @var string
     */
    private $method;

    public function __construct(stdClass $controller, string $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    public function handle(Request $request): Response
    {
        return $this->controller->{$this->method}($request);
    }
}