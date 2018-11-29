<?php

namespace Apiate;

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
}