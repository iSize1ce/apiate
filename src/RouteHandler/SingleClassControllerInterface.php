<?php

namespace Apiate\RouteHandler;

use Apiate\Request;
use Symfony\Component\HttpFoundation\Response;

interface SingleClassControllerInterface
{
    public function handle(Request $request): Response;
}