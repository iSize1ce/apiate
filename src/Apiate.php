<?php

namespace Apiate;

use Apiate\ResponseSender\DefaultResponseSender;
use Apiate\ResponseSender\ResponseSenderInterface;
use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Apiate\Route\RouteProvider;
use Apiate\RouteMatcher\DefaultRouteMatcher;
use Apiate\RouteMatcher\RouteMatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class Apiate
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routes;

    /**
     * @var \Closure[]
     */
    private $beforeMiddleware;

    /**
     * @var \Closure[]
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

    public function __construct(?RouteMatcherInterface $routeMatcher = null, ?ResponseSenderInterface $responseSender = null)
    {
        $this->routes = new RouteCollection();

        $this->routeMatcher = $routeMatcher ?? new DefaultRouteMatcher($this->routes);
        $this->responseSender = $responseSender ?? new DefaultResponseSender();
    }

    public function getRoutes(): RouteProvider
    {
        return new RouteProvider('', $this->routes);
    }

    public function handle(Request $request): void
    {
        foreach ($this->beforeMiddleware as $before) {
            $responseFromBefore = $before($request);

            if ($responseFromBefore instanceof Response) {
                $this->sendResponse($responseFromBefore);

                return;
            }
        }

        $matchedRoute = $this->routeMatcher->getRouteByRequest($request);

        if (!$matchedRoute) {
            throw new RouteNotFoundException();
        }

        $response = $matchedRoute->getHandler()->handle($request);

        foreach ($this->afterMiddleware as $after) {
            $responseFromAfter = $after($request, $response);

            if ($responseFromAfter instanceof Response) {
                $this->sendResponse($responseFromAfter);

                return;
            }
        }

        $this->sendResponse($response);
    }

    public function before(\Closure $closure, ?int $weight = null): self
    {
        $this->beforeMiddleware[$weight] = $closure;

        return $this;
    }

    public function after(\Closure $closure, ?int $weight = null): self
    {
        $this->afterMiddleware[$weight] = $closure;

        return $this;
    }

    public function sendResponse(Response $response, ?Request $request = null): void
    {
        if ($request !== null) {
            $response->prepare($request);
        }

        $this->responseSender->send($response);
    }
}