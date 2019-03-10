<?php

namespace Apiate\RouteHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface SingleClassControllerInterface
{
    public function handle(RequestInterface $request): ResponseInterface;
}