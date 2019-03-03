<?php

use Apiate\{Apiate,
    HTTP\JSONResponse,
    HTTP\Request,
    HTTP\Response,
    RouteHandler\ClosureRouteHandler,
    Route\RouteProvider};
use Symfony\Component\HttpFoundation\ParameterBag;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Throwable $exception) use ($app) {
    $app->sendResponse(new JSONResponse(['status' => false, 'result' => $exception->getMessage()]));

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
            $id = (int)$request->uriParameters->get('id');
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
    if ($response instanceof JSONResponse) {
        $response->setDecodedContent([
            'status' => true,
            'result' => $response->getDecodedContent()
        ]);
    }
});

$request = Request::createFromGlobals();

$app->handle($request);

die();