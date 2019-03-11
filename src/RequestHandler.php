<?php

namespace Apiate;

use Apiate\RouteMatcher\RouteMatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    public function __construct(RouteMatcherInterface $routeMatcher)
    {
        $this->routeMatcher = $routeMatcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $matchedRoute = $this->routeMatcher->getRouteByRequest($request);

        return $matchedRoute->getHandler()->handle($request);
    }
}