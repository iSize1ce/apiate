<?php

namespace Apiate\Route;

use Apiate\RouteHandler\RouteHandlerInterface;

interface RouteInterface
{
    public function getMethod(): string;

    public function getPath(): string;

    public function getHandler(): RouteHandlerInterface;
}