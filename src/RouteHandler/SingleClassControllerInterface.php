<?php

namespace Apiate\RouteHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface SingleClassControllerInterface
{
    public function handle(Request $request): Response;
}