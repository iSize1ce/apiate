<?php

namespace Apiate\RouteMatcher;

use Apiate\Route\Route;
use Psr\Http\Message\ServerRequestInterface;

interface RouteMatcherInterface
{
    public function getRouteByRequest(ServerRequestInterface $request): Route;
}