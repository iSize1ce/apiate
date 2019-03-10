<?php

namespace Apiate\ResponseSender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultResponseSender implements ResponseSenderInterface
{
    public function send(ResponseInterface $response): void
    {
        if ($response instanceof ServerRequestInterface) {
            // Cookies
            foreach ($response->getCookieParams() as $name => $value) {
                setcookie($name, $value);
            }
        }

        // Headers
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value");
            }
        }

        // Http status
        header("HTTP/{$response->getProtocolVersion()} {$response->getStatusCode()} {$response->getReasonPhrase()}");

        echo $response->getBody()->getContents();
    }
}