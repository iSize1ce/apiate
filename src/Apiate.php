<?php

namespace Apiate;

use Apiate\ResponseSender\DefaultResponseSender;
use Apiate\ResponseSender\ResponseSenderInterface;
use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Apiate\Route\RouteProvider;
use Apiate\RouteMatcher\DefaultRouteMatcher;
use Apiate\RouteMatcher\RouteMatcherInterface;
use Closure;

class Apiate
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routes;

    /**
     * @var Closure[]
     */
    private $beforeMiddleware;

    /**
     * @var Closure[]
     */
    private $afterMiddleware;

    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    /**
     * @var ResponseSenderInterface
     */
    private $responseSender;

    public function __construct(?RouteCollection $routeCollection = null, ?RouteMatcherInterface $routeMatcher = null, ?ResponseSenderInterface $responseSender = null)
    {
        $this->routes = $routeCollection ?? new RouteCollection();
        $this->routeMatcher = $routeMatcher ?? new DefaultRouteMatcher($this->routes);
        $this->responseSender = $responseSender ?? new DefaultResponseSender();
    }

    public function getRoutes(): RouteProvider
    {
        return new RouteProvider('', $this->routes);
    }

    public function handle(Request $request): void
    {
        $response = null;

        foreach ($this->beforeMiddleware as $before) {
            $response = $before($request);
        }

        if ($response === null) {
            $matchedRoute = $this->routeMatcher->getRouteByRequest($request);

            $response = $matchedRoute->getHandler()->handle($request);
        }

        foreach ($this->afterMiddleware as $after) {
            $after($request, $response);
        }

        $this->sendResponse($response);
    }

    public function before(Closure $closure, ?int $weight = null): self
    {
        $this->beforeMiddleware[$weight] = $closure;

        return $this;
    }

    public function after(Closure $closure, ?int $weight = null): self
    {
        $this->afterMiddleware[$weight] = $closure;

        return $this;
    }

    public function sendResponse(Response $response, ?Request $request = null): void
    {
        // @TODO move to sender or remove
        if ($request !== null) {
            $response->prepare($request);
        }

        $this->responseSender->send($response);
    }
}