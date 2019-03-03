<?php

namespace Apiate\HTTP;

class JSONResponse extends Response
{
    private $decodedContent;

    public function __construct($data, int $status = 200)
    {
        $this->decodedContent = $data;

        parent::__construct(null, $status, ['Content-Type' => 'application/json']);
    }

    public function getDecodedContent()
    {
        return $this->decodedContent;
    }

    public function setDecodedContent($decodedContent): void
    {
        $this->decodedContent = $decodedContent;
    }

    public function sendContent()
    {
        echo json_encode($this->decodedContent);

        return $this;
    }
}