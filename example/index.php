<?php

use Apiate\Apiate;
use Apiate\Handler\ClosureHandler;
use Apiate\Route\RouteProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Exception $exception) use ($app) {
    $app->sendResponse(new JsonResponse($exception->getMessage()));

    die();
});

$routes = $app->getRoutes();

$routes->createNamespace('/api', function (RouteProvider $apiRoutes) {
    $apiRoutes->get('/', new ClosureHandler(function () {
        return new JsonResponse('Hello API!');
    }));

    $apiRoutes->createNamespace('/news', function (RouteProvider $newsRoutes) {
        $newsRoutes->get('/', new ClosureHandler(function () {
            return new JsonResponse([
                ['id' => 1, 'text' => 'News #1'],
                ['id' => 2, 'text' => 'News #2']
            ]);
        }));

        $newsRoutes->post('/', new ClosureHandler(function (Request $request) {
            return new JsonResponse(
                ['id' => 3, 'text' => $request->request->get('text')]
            );
        }));

        $newsRoutes->get('/{id=\d+}', new ClosureHandler(function (int $id) {
            return new JsonResponse(['id' => $id, 'text' => "News #$id"]);
        }));
    });
});

$app->before(function (Request $request) {
    if ($request->getClientIp() !== '127.0.0.1') {
        return new JsonResponse(null, 403);
    }
});

$app->after(function (Request $request, Response $response) {
    if ($request->isMethod('GET')) {
        return new JsonResponse();
    }

    $response->setMaxAge(123);
});


$request = Request::createFromGlobals();

$app->handle($request);

die();