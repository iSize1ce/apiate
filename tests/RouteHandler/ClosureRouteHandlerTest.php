<?php

namespace Apiate\RouteHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @covers ClosureRouteHandler
 */
class ClosureRouteHandlerTest extends TestCase
{
    /**
     * @covers ClosureRouteHandler::handle
     */
    public function testHandle()
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