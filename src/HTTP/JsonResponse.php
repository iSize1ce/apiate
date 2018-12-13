<?php

namespace Apiate\HTTP;

class JsonResponse extends Response
{
    private $data;

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->body = json_encode($data);

        $this->getHeaders()->offsetSet('Content-Type', 'application/json');
    }
}