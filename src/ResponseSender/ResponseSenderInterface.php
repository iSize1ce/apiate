<?php

namespace Apiate\ResponseSender;

use Psr\Http\Message\ResponseInterface;

interface ResponseSenderInterface
{
    public function send(ResponseInterface $response): void;
}