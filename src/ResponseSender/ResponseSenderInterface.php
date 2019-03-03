<?php

namespace Apiate\ResponseSender;

use Symfony\Component\HttpFoundation\Response;

interface ResponseSenderInterface
{
    public function send(Response $response): void;
}