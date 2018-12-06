<?php

use Apiate\Apiate;
use Apiate\Handler\ClosureHandler;
use Apiate\Route\RouteProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Throwable $exception) use ($app) {
    $app->sendResponse(new JsonResponse('Error: ' . $exception->getMessage()));

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

        $newsRoutes->get('/{id=\d+}', new ClosureHandler(function (Request $request) {
            return new JsonResponse(['id' => 123, 'text' => "News #123"]);
        }));

        $newsRoutes->get('/{parameterOne}/{parameterTwo}', new ClosureHandler(function (Request $request) {
            return new JsonResponse('hi');
        }));
    });
});

$app->before(function (Request $request) {
    // @todo
});

$app->after(function (Request $request, Response $response) {
    if ($response instanceof JsonResponse) {
        $data = json_decode($response->getContent());

        $response->setData(['status' => true, 'result' => $data]);
    }
});


$request = Request::createFromGlobals();

$app->handle($request);

die();