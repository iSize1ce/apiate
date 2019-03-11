<?php

namespace Apiate\RequestHandler;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClosureRequestHandler implements RequestHandlerInterface
{
    /**
     * @var Closure
     */
    private $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $closure = $this->closure;

        return $closure($request);
    }
}