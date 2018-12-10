<?php

use Apiate\{Apiate, Handler\ClosureHandler, HTTP\JsonResponse, HTTP\Request};

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

$routes = $app->getRoutes();

$routes->get('/', new ClosureHandler(function (Request $request) {
    return new JsonResponse([
        'host' => $request->getHeaders()->offsetGet('HOST'),
        'path' => $request->getUriPath(),
        'uriParameters' => $request->getUriParameters()->getArrayCopy(),
        'headers' => $request->getHeaders()->getArrayCopy(),
        'cookies' => $request->getCookies()->getArrayCopy(),
    ]);
}));

$request = Request::createFromGlobals();

$app->handle($request);

die();