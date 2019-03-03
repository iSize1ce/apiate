<?php

namespace Apiate\RouteHandler;

use Apiate\HTTP\Request;
use Apiate\HTTP\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @covers ControllerRouteHandler
 */
class ControllerRouteHandlerTest extends TestCase
{
    /**
     * @covers ControllerRouteHandler::handle
     */
    public function handleTest()
    {
        $request = new Request();
        $response = new Response('Test response');

        $controller = $this->createMock(\stdClass::class);
        $controller->expects($this->once())
            ->method('testMethod')
            ->willReturn($response);

        $handler = new ControllerRouteHandler($controller, 'testMethod');

        $expected = $handler->handle($request);

        $this->assertEquals($expected, $response);
    }
}