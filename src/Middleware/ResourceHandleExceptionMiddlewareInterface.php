<?php

namespace Middleware;

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;

interface ResourceHandleExceptionMiddlewareInterface extends MiddlewareInterface
{
    public function __invoke(ResourceInterface $resource, Request $request, \Exception $exception);
}