<?php

namespace Apiate\Route;

use Apiate\RequestHandler\RequestHandlerInterface;

interface RouteInterface
{
    public function getMethod(): string;

    public function getPath(): string;

    public function getHandler(): RequestHandlerInterface;
}