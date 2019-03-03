<?php

namespace Apiate\RouteHandler;

use stdClass;
use Apiate\Request;
use Apiate\Response;

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