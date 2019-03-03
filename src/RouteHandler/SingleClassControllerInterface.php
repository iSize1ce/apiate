<?php

namespace Apiate\RouteHandler;

use Apiate\Request;
use Apiate\Response;

interface SingleClassControllerInterface
{
    public function handle(Request $request): Response;
}