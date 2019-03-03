<?php

namespace Apiate\RouteHandler;

use Apiate\HTTP\Request;
use Apiate\HTTP\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class ClosureRouteHandlerTest extends TestCase
{
    public function handleTest()
    {
        $request = new Request();
        $response = new Response('Test response');

        $closure = function (Request $request) use ($response): Response {
            return $response;
        };

        $handler = new ClosureRouteHandler($closure);

        $expected = $handler->handle($request);

        $this->assertEquals($expected, $response);
    }
}