<?php

namespace Apiate\RouteMatcher;

use Apiate\HTTP\Request;
use Apiate\Route\Route;
use Apiate\Route\RouteCollection;

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

    public function getRouteByRequest(Request $request): Route
    {
        $requestPath = $request->getPathInfo();
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
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $request->uriParameters->set($key, $match[0]);
                    }
                }

                return $route;
            }
        }

        throw new RouteNotFoundException();
    }
}