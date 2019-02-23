<?php

namespace Apiate\Route;

use Apiate\RouteHandler\RouteHandlerInterface;

class Route
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
     * @var RouteHandlerInterface
     */
    private $handler;

    public function __construct(string $method, string $path, RouteHandlerInterface $handler)
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
     * @return RouteHandlerInterface
     */
    public function getHandler(): RouteHandlerInterface
    {
        return $this->handler;
    }
}