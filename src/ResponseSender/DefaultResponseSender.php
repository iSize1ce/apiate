<?php

namespace Apiate\ResponseSender;

use Symfony\Component\HttpFoundation\Response;

class DefaultResponseSender implements ResponseSenderInterface
{
    public function send(Response $response): void
    {
        $response->send();
    }
}