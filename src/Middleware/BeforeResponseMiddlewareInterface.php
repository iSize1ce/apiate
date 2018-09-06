<?php

namespace Middleware;

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface BeforeResponseMiddlewareInterface extends MiddlewareInterface
{
    public function __invoke(ResourceInterface $resource, Request $request, Response $response);
}