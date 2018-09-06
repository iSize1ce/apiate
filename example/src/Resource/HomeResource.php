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

        if ($text) {
            $this->text = $text;
        }
        else {
            throw new Exception();
        }
    }

    public function handle(): Response
    {
        return new JsonResponse($this->text, 404);
    }
}