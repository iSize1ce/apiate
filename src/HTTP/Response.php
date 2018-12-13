<?php

namespace Apiate\HTTP;

class Response
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var Parameters
     */
    private $headers;

    public function __construct()
    {
        $this->headers = new Parameters();
    }

    public function send(): void
    {
        foreach ($this->getHeaders() as $name => $value) {
            header("$name:$value");
        }

        echo $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getHeaders(): Parameters
    {
        return $this->headers;
    }
}