<?php

namespace Apiate\RouteMatcher;

use Apiate\HTTP\Request;
use Apiate\Route\Route;

interface RouteMatcherInterface
{
    public function getRouteByRequest(Request $request): Route;
}