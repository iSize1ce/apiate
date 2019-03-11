<?php

namespace Apiate\RequestHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var RequestHandlerInterface
     */
    private $requestHandler;

    public function __construct(RequestHandlerInterface $controller)
    {
        $this->requestHandler = $controller;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->requestHandler->handle($request);
    }
}