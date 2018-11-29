<?php

namespace Apiate\Handler;

use Apiate\Request;
use Apiate\Response;

interface HandlerInterface
{
    public function handle(Request $request): Response;
}