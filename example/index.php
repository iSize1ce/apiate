<?php

use Apiate\{Apiate, ClosureHandler, JsonResponse, Request, RouteCollection};

$app = new Apiate();

$routes = $app->getRoutes();

$routes->createNamespace('/api', function (RouteCollection $apiRoutes) {
    $apiRoutes->get('/', new ClosureHandler(function () {
        return new JsonResponse('Hello API!');
    }));

    $apiRoutes->createNamespace('/news', function (RouteCollection $newsRoutes) {
        $newsRoutes->get('/', new ClosureHandler(function () {
            return new JsonResponse([
                ['id' => 1, 'text' => 'News #1'],
                ['id' => 2, 'text' => 'News #2']
            ]);
        }));

        $newsRoutes->post('/', new ClosureHandler(function (Request $request) {
            return new JsonResponse(
                ['id' => 3, 'text' => $request->getPost()->get('text')]
            );
        }));

        $newsRoutes->get('/{/<id>(\d+)/}', new ClosureHandler(function (int $id) {
            return new JsonResponse(['id' => $id, 'text' => "News #$id"]);
        }));
    });
});

$request = Request::createFromGlobals();

$app->handle($request);

die();