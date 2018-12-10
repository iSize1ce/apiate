<?php

namespace Apiate\Handler;

use Apiate\HTTP\{Request, Response};

interface HandlerInterface
{
    public function handle(Request $request): Response;
}