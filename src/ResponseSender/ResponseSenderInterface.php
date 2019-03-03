<?php

namespace Apiate\ResponseSender;

use Apiate\HTTP\Response;

interface ResponseSenderInterface
{
    public function send(Response $response): void;
}