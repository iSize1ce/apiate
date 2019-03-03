<?php

namespace Apiate\RouteHandler;

use Apiate\HTTP\Request;
use Apiate\HTTP\Response;

interface SingleClassControllerInterface
{
    public function handle(Request $request): Response;
}