<?php

namespace Apiate\RouteMatcher;

use Symfony\Component\HttpFoundation\Request;
use Apiate\Route\RouteCollection;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @covers DefaultRouteMatcher
 */
class DefaultRouteMatcherTest extends TestCase
{
    /**
     * @covers DefaultRouteMatcher::getRouteByRequest
     */
    public function testGetRouteByRequestNotFound()
    {
        $emptyRouteCollection = new RouteCollection();
        $routeMatcher = new DefaultRouteMatcher($emptyRouteCollection);

        $request = new Request();

        $this->expectException(RouteNotFoundException::class);

        $routeMatcher->getRouteByRequest($request);
    }
}