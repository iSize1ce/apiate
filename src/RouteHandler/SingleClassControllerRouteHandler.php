<?php

namespace Apiate\RouteHandler;

use Apiate\Request;
use Apiate\Response;

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