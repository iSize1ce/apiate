<?php

namespace Apiate\RouteHandler;

use Closure;
use Apiate\Request;
use Apiate\Response;

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