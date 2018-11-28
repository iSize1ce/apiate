<?php

namespace Apiate;

class RouteCollection
{
    public function createNamespace(string $pathPart, \Closure $closure): void
    {
        $namespace = new RouteCollection();
        $closure($namespace);
    }

    public function get(string $string, HandlerInterface $handler)
    {

    }

    public function post(string $string, HandlerInterface $handler)
    {

    }
}