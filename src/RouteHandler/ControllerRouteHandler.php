<?php

namespace Apiate\RouteHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->controllerObject->{$this->method}($request);
    }
}