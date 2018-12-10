<?php

namespace Apiate\HTTP;

class JsonResponse extends Response
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->body = json_encode($data);
    }
}