<?php

namespace Apiate\RouteHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function handle(Request $request): Response
    {
        return $this->controller->handle($request);
    }
}