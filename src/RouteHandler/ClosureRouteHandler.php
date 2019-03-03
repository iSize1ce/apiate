<?php

namespace Apiate\RouteHandler;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClosureRouteHandler implements RouteHandlerInterface
{
    /**
     * @var Closure
     */
    private $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function handle(Request $request): Response
    {
        $closure = $this->closure;

        return $closure($request);
    }
}