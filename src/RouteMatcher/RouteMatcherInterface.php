<?php

namespace Apiate\RouteMatcher;

use Apiate\Request;
use Apiate\Route\Route;

interface RouteMatcherInterface
{
    public function getRouteByRequest(Request $request): Route;
}