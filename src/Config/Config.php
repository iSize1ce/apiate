<?php

namespace Apiate\Config;

class Config
{
    /**
     * @var ResourceConfig[]
     */
    private $resources;

    /**
     * @param ResourceConfig[] $resources
     */
    public function __construct(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @return ResourceConfig[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}