<?php

namespace Apiate\Route;

use Apiate\Handler\HandlerInterface;

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
     * @var HandlerInterface
     */
    private $handler;

    public function __construct(string $method, string $path, HandlerInterface $handler)
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
     * @return HandlerInterface
     */
    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }
}