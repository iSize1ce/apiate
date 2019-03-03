<?php

namespace Apiate\ResponseSender;

use Apiate\HTTP\Response;

class DefaultResponseSender implements ResponseSenderInterface
{
    public function send(Response $response): void
    {
        $response->send();
    }
}