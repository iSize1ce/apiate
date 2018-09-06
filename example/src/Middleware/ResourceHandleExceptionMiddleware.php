<?php

namespace Middleware;

use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ResourceHandleExceptionMiddleware implements ResourceHandleExceptionMiddlewareInterface
{
    public function __invoke(ResourceInterface $resource, Request $request, \Exception $exception)
    {
        return 'fds';
    }
}