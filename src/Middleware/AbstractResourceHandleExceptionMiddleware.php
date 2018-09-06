<?php

namespace Middleware;

use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResourceHandleExceptionMiddleware implements ResourceHandleExceptionMiddlewareInterface
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @param Response $response
     */
    protected function setResponse(Response $response)
    {
        $this->response = $response;
    }
}