<?php

namespace Apiate\ResponseSender;

use Apiate\HTTP\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @covers DefaultResponseSender
 */
class DefaultResponseSenderTest extends TestCase
{
    /**
     * @covers DefaultResponseSender::send
     */
    public function testSend()
    {
        /** @var Response|MockObject $response */
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('send');

        $sender = new DefaultResponseSender();
        $sender->send($response);
    }
}