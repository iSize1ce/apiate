<?php

namespace Apiate\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TestRouteHandler implements RouteHandlerInterface
{
    public function handle(Request $request): Response
    {
        return new Response();
    }
}

/**
 * @group unit
 * @covers RequestHandler
 */
class SingleClassControllerRouteHandlerTest extends TestCase
{
    /**
     * @covers RequestHandler::handle
     */
    public function testHandle()
    {
        $request = new Request();
        $response = new Response('Test response');

        /** @var RouteHandlerInterface|MockObject $controller */
        $controller = $this->createMock(TestRouteHandler::class);
        $controller
            ->expects($this->once())
            ->method('handle')
            ->willReturn($response);

        $handler = new RequestHandler($controller);

        $actual = $handler->handle($request);

        $this->assertEquals($response, $actual);
    }
}