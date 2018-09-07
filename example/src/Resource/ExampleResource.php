<?php

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExampleResource implements ResourceInterface
{
    /**
     * @var string
     */
    private $username;

    public function __construct(Request $request)
    {
        $id = $request->query->get('id');

        $isIdExistsInDatabase = true;

        if ( ! $isIdExistsInDatabase) {
            throw new Exception("User with id=$id does not exist!");
        }

        $usernameFromDatabase = 'HelloWorldUserName123';

        $this->username = $usernameFromDatabase;
    }

    public function handle(): Response
    {
        return new JsonResponse("Hello world by $this->username");
    }
}