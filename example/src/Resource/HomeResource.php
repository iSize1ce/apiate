<?php

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeResource implements ResourceInterface
{
    /**
     * @var string
     */
    private $text;

    public function __construct(Request $request)
    {
        $text = $request->query->get('text');

        if ( ! $text) {
            throw new Exception('You must send some text!');
        }

        $this->text = $text;
    }

    public function handle(): Response
    {
        return new JsonResponse("Text is \"$this->text\"");
    }
}