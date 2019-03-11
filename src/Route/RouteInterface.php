<?php

namespace Apiate\Route;

use Psr\Http\Server\RequestHandlerInterface;

interface RouteInterface
{
    public function getMethod(): string;

    public function getPath(): string;

    public function getHandler(): RequestHandlerInterface;
}