<?php

namespace Apiate\Route;

use Apiate\Handler\HandlerInterface;

class Route
{
    /**
     * @var string[]
     */
    private $methods;

    /**
     * @var string
     */
    private $path;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @param string[] $methods
     */
    public function __construct(array $methods, string $path, HandlerInterface $handler)
    {
        $this->methods = $methods;
        $this->path = $path;
        $this->handler = $handler;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }
}