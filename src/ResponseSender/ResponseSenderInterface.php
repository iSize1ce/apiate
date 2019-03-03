<?php

namespace Apiate\ResponseSender;

use Apiate\Response;

interface ResponseSenderInterface
{
    public function send(Response $response): void;
}