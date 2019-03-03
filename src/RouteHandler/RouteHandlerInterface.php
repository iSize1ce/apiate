<?php

namespace Apiate\RouteHandler;

use Apiate\Request;
use Apiate\Response;

interface RouteHandlerInterface
{
    public function handle(Request $request): Response;
}