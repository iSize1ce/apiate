<?php

use Apiate\{Apiate, Handler\ClosureHandler, HTTP\JsonResponse, HTTP\Request};

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Throwable $throwable) use ($app) {
    if ($throwable instanceof \Apiate\RouteNotFoundException) {
        $app->sendResponse(new \Apiate\HTTP\Response());
    }
});

$routes = $app->getRoutes();

$routes->handle('/',
    [Request::METHOD_GET, Request::METHOD_POST, Request::METHOD_DELETE, Request::METHOD_PUT],
    new ClosureHandler(function (Request $request) {
        $response = new JsonResponse([
            'host' => $request->getHeaders()->offsetGet('HOST'),
            'path' => $request->getUriPath(),
            'uriParameters' => $request->getUriParameters()->getArrayCopy(),
            'headers' => $request->getHeaders()->getArrayCopy(),
            'cookies' => $request->getCookies()->getArrayCopy(),
            'files' => $request->getFiles()->getArrayCopy()
        ]);

        $response->getCookies()->offsetSet('test', rand(0, 1000));

        return $response;
    })
);

$request = Request::createFromGlobals();

$app->handle($request);

die();