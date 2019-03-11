<?php

namespace Apiate\RouteMatcher;

use Apiate\Route\Route;
use Apiate\Route\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;

class DefaultRouteMatcher implements RouteMatcherInterface
{
    /**
     * @var RouteCollection|Route[]
     */
    private $routeCollection;

    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function getRouteByRequest(ServerRequestInterface $request): Route
    {
        $requestPath = $request->getUri()->getPath();
        $requestMethod = $request->getMethod();

        $matchedRoute = null;
        foreach ($this->routeCollection as $route) {
            if ($route->getMethod() !== $requestMethod) {
                continue;
            }

            $routePath = $route->getPath();

            $routePathRegex = preg_replace('/{([a-z]+)}/Ui', '(?<$1>.*)', $routePath);
            $routePathRegex = preg_replace('/{([a-z]+)=(.*)}/Ui', '(?<$1>$2)', $routePathRegex);
            $routePathRegex = str_replace('/', '\/', $routePathRegex);

            if (preg_match_all('/^' . $routePathRegex . '$/Ui', $requestPath, $matches) === 1) {
                return $route;
            }
        }

        throw new RouteNotFoundException();
    }
}