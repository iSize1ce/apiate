<?php

namespace Apiate\RouteMatcher;

use Symfony\Component\HttpFoundation\Request;
use Apiate\Route\Route;

interface RouteMatcherInterface
{
    public function getRouteByRequest(Request $request): Route;
}