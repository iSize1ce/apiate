<?php

namespace Apiate\RouteHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\TestCase;

class TestController
{
    public function testMethod(Request $request): Response
    {
        return new Response();
    }
}

/**
 * @group unit
 * @covers ControllerRouteHandler
 */
class ControllerRouteHandlerTest extends TestCase
{
    /**
     * @covers ControllerRouteHandler::handle
     */
    public function testHandle()
    {
        $request = new Request();
        $response = new Response('Test response');

        $controller = $this->createMock(TestController::class);
        $controller
            ->expects($this->once())
            ->method('testMethod')
            ->willReturn($response);

        $handler = new ControllerRouteHandler($controller, 'testMethod');

        $expected = $handler->handle($request);

        $this->assertEquals($expected, $response);
    }
}