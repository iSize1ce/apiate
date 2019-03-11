<?php

namespace Apiate\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @covers ClosureRequestHandler
 */
class ClosureRouteHandlerTest extends TestCase
{
    /**
     * @covers ClosureRequestHandler::handle
     */
    public function testHandle()
    {
        $request = new Request();
        $response = new Response('Test response');

        $closure = function (Request $request) use ($response): Response {
            return $response;
        };

        $handler = new ClosureRequestHandler($closure);

        $expected = $handler->handle($request);

        $this->assertEquals($expected, $response);
    }
}