<?php

namespace Apiate\Route;

use Psr\Http\Server\RequestHandlerInterface;

class Route implements RouteInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var RequestHandlerInterface
     */
    private $handler;

    public function __construct(string $method, string $path, RequestHandlerInterface $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return RequestHandlerInterface
     */
    public function getHandler(): RequestHandlerInterface
    {
        return $this->handler;
    }
}