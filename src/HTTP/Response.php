<?php

namespace Apiate\HTTP;

class Response
{
    /**
     * @var string
     */
    protected $body;

    public function send(): void
    {
        echo $this->body;
    }
}