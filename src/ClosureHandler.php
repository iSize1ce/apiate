<?php

namespace Apiate;

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
        return $this->closure($request);
    }
}