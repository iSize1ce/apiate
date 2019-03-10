<?php

namespace Apiate\RouteHandler;

use Closure;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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

    public function handle(RequestInterface $request): ResponseInterface
    {
        $closure = $this->closure;

        return $closure($request);
    }
}