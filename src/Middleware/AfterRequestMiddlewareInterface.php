<?php

namespace Middleware;

use Symfony\Component\HttpFoundation\Request;

interface AfterRequestMiddlewareInterface extends MiddlewareInterface
{
    public function __invoke(Request $request);
}