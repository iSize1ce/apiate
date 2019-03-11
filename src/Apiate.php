<?php

namespace Apiate;

use Apiate\ResponseSender\DefaultResponseSender;
use Apiate\ResponseSender\ResponseSenderInterface;
use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Apiate\Route\RouteProvider;
use Apiate\RouteMatcher\DefaultRouteMatcher;
use Closure;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Apiate
{
    /**
     * @var RequestHandlerInterface
     */
    private $requestHandler;

    /**
     * @var RouteCollection|Route[]
     */
    private $routeCollection;

    /**
     * @var ResponseSenderInterface
     */
    private $responseSender;

    /**
     * @var MiddlewareInterface[]
     */
    private $beforeMiddleware;

    /**
     * @var MiddlewareInterface[]
     */
    private $afterMiddleware;

    public function __construct(?RequestHandlerInterface $requestHandler = null, ?RouteCollection $routeCollection = null, ?ResponseSenderInterface $responseSender = null)
    {
        $this->requestHandler = $requestHandler ?? new RequestHandler(new DefaultRouteMatcher())
        $this->routeCollection = $routeCollection ?? new RouteCollection();
        $this->responseSender = $responseSender ?? new DefaultResponseSender();
        $this->requestHandler = $requestHandler;
    }

    public function handle(ServerRequestInterface $request): void
    {
        $response = null;

        foreach ($this->beforeMiddleware as $before) {
            $response = $before->process($request, $this->requestHandler);
        }

        $response = $this->requestHandler->handle($request);

        foreach ($this->afterMiddleware as $after) {
            $response = $after->process($request, $this->requestHandler);
        }

        $this->responseSender->send($response);
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

    public function getRouteProvider(): RouteProvider
    {
        return new RouteProvider('', $this->routeCollection);
    }
}