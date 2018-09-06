<?php

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExampleResource implements ResourceInterface
{
    /**
     * @var stdClass
     */
    private $example;

    public function __construct(Request $request)
    {
        $id = $request->query->get('id');

        $isIdExistsInDatabase = true;

        if ($isIdExistsInDatabase) {
            $example = new stdClass();
            $example->id = $id;

            $this->example = $example;
        }
        else {
            throw new Exception();
        }
    }

    public function handle(): Response
    {
        $name = $this->example->name;

        return new \Symfony\Component\HttpFoundation\JsonResponse("Hello world by $name");
    }
}