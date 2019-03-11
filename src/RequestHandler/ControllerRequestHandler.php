<?php

namespace Apiate\RequestHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerRequestHandler implements RequestHandlerInterface
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->controllerObject->{$this->method}($request);
    }
}