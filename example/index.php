<?php

use Apiate\Apiate;
use Apiate\RouteHandler\ClosureRouteHandler;
use Apiate\Route\RouteProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Throwable $exception) use ($app) {
    $app->sendResponse(new JsonResponse(['status' => false, 'result' => $exception->getMessage()]));

    die();
});

$routes = $app->getRoutes();

$routes->get('/', new ClosureRouteHandler(function () {
    return new JSONResponse('Hello world!');
}));

$routes->createNamespace('/news', function (RouteProvider $newsRoutes) {
    $newsRoutes->get('/', new ClosureRouteHandler(function () {
        return new JSONResponse([
            ['id' => 1, 'text' => 'News #1'],
            ['id' => 2, 'text' => 'News #2']
        ]);
    }));

    $newsRoutes->post('/', new ClosureRouteHandler(function (Request $request) {
        return new JSONResponse(
            ['id' => 3, 'text' => $request->request->get('text')]
        );
    }));

    $newsRoutes->createNamespace('/{id=\d+}', function (RouteProvider $newsWithIdRoutes) {
        $newsWithIdRoutes->get('/', new ClosureRouteHandler(function (Request $request) {
            $id = (int)$request->attributes->get('id');
            return new JSONResponse(['id' => $id, 'text' => "News #$id"]);
        }));

        $newsWithIdRoutes->put('/', new ClosureRouteHandler(function (Request $request) {
            return new JSONResponse(['id' => 4, 'text' => $request->request->get('text')]);
        }));
    });
});

$app->before(function (Request $request) {
    $isContentTypeJson = $request->headers->get('Content-Type') === 'application/json';
    if ($isContentTypeJson) {
        $json = $request->getContent();
        $decodedJson = json_decode($json, true);

        $request->request = new ParameterBag($decodedJson);
    }
});

$app->after(function (Request $request, Response $response) {
    $data = json_decode($response->getContent(), true);
    if ($response instanceof JSONResponse) {
        $response->setData([
            'status' => true,
            'result' => $data
        ]);
    }
});

$request = Request::createFromGlobals();

$app->handle($request);

die();