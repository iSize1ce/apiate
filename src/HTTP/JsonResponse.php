<?php

namespace Apiate\HTTP;

class JsonResponse extends Response
{
    private $data;

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->setBody(json_encode($data));

        $this->getHeaders()->offsetSet('Content-Type', 'application/json');
    }
}