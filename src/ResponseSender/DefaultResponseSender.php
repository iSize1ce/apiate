<?php

namespace Apiate\ResponseSender;

use Psr\Http\Message\ResponseInterface;

class DefaultResponseSender implements ResponseSenderInterface
{
    public function send(ResponseInterface $response): void
    {
        $response->send();
    }
}