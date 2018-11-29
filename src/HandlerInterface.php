<?php

namespace Apiate;

interface HandlerInterface
{
    public function handle(Request $request): Response;
}