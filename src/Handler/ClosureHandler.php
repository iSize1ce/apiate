<?php

namespace Apiate\Handler;

use Apiate\Request;
use Apiate\Response;

class ClosureHandler implements HandlerInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public function handle(Request $request): Response
    {
        $closure = $this->closure;

        return $closure($request);
    }
}