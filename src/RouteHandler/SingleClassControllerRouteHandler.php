<?php

namespace Apiate\RouteHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SingleClassControllerRouteHandler implements RouteHandlerInterface
{
    /**
     * @var SingleClassControllerInterface
     */
    private $controller;

    public function __construct(SingleClassControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->controller->handle($request);
    }
}