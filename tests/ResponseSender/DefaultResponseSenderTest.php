<?php

namespace Apiate\ResponseSender;

use Apiate\HTTP\Response;
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
        /** @var Response $response */
        $response = $this->createMock(Response::class)
            ->expects($this->once())
            ->method('send');

        $sender = new DefaultResponseSender();
        $sender->send($response);
    }
}