<?php

namespace Apiate\Resource;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ResourceInterface
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request);

    /**
     * @return Response
     */
    public function handle(): Response;
}