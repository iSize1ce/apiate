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

    /**
     * @var Parameters
     */
    private $cookies;

    public function __construct()
    {
        $this->headers = new Parameters();
        $this->cookies = new Parameters();
    }

    public function send(): void
    {
        $cookies = [];
        foreach ($this->getCookies() as $name => $value) {
            $cookies[] = "$name=$value";
        }
        if (count($cookies) > 0) {
            header('Cookie: ' . implode(';', $cookies));
        }

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

    public function setCookies(Parameters $cookies): void
    {
        $this->cookies = $cookies;
    }

    public function getCookies(): Parameters
    {
        return $this->cookies;
    }
}