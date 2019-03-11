<?php

namespace Apiate\RequestHandler;

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
 * @covers ControllerRequestHandler
 */
class ControllerRouteHandlerTest extends TestCase
{
    /**
     * @covers ControllerRequestHandler::handle
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

        $handler = new ControllerRequestHandler($controller, 'testMethod');

        $expected = $handler->handle($request);

        $this->assertEquals($expected, $response);
    }
}