<?php

namespace Apiate\HTTP;

class Response
{
    /**
     * @var string
     */
    protected $body;

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

    public function getHeaders(): Parameters
    {
        return $this->headers;
    }
}