<?php

namespace Apiate\RouteMatcher;

use Psr\Http\Message\RequestInterface;
use Apiate\Route\Route;

interface RouteMatcherInterface
{
    public function getRouteByRequest(RequestInterface $request): Route;
}