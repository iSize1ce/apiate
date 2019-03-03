<?php

namespace Apiate\RouteHandler;

use Apiate\HTTP\Request;
use Apiate\HTTP\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TestSingleClassController implements SingleClassControllerInterface
{
    public function handle(Request $request): Response
    {
        return new Response();
    }
}

/**
 * @group unit
 * @covers SingleClassControllerRouteHandler
 */
class SingleClassControllerRouteHandlerTest extends TestCase
{
    /**
     * @covers SingleClassControllerRouteHandler::handle
     */
    public function testHandle()
    {
        $request = new Request();
        $response = new Response('Test response');

        /** @var SingleClassControllerInterface|MockObject $controller */
        $controller = $this->createMock(TestSingleClassController::class);
        $controller
            ->expects($this->once())
            ->method('handle')
            ->willReturn($response);

        $handler = new SingleClassControllerRouteHandler($controller);

        $actual = $handler->handle($request);

        $this->assertEquals($response, $actual);
    }
}