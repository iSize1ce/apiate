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
     * @return AbstractResourceHandleExceptionMiddleware
     */
    protected function setResponse(Response $response): AbstractResourceHandleExceptionMiddleware
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}