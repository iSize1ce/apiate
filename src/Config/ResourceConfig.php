<?php

namespace Apiate\Config;

class ResourceConfig
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $class;

    /**
     * @param string $path
     * @param string $method
     * @param string $class
     */
    public function __construct(string $path, string $method, string $class)
    {
        $this->path = $path;
        $this->method = $method;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
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
    public function getClass(): string
    {
        return $this->class;
    }
}