# Apiate

```php
use Apiate\{Apiate, Request, Handler\ClosureHandler, Route\RouteProvider};
use Symfony\Component\HttpFoundation\{JsonResponse, Response};

include_once __DIR__ . '/vendor/autoload.php';

$app = new Apiate();

set_exception_handler(function (Throwable $exception) use ($app) {
    $app->sendResponse(new JsonResponse(['status' => false, 'result' => $exception->getMessage()]));

    die();
});

$routes = $app->getRoutes();

$routes->get('/', new ClosureHandler(function () {
    return new JsonResponse('Hello world!');
}));

$routes->createNamespace('/news', function (RouteProvider $newsRoutes) {
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

    $newsRoutes->createNamespace('/{id=\d+}', function (RouteProvider $newsWithIdRoutes) {
        $newsWithIdRoutes->get('/', new ClosureHandler(function (Request $request) {
            $id = (int)$request->uriParameters->get('id');
            return new JsonResponse(['id' => $id, 'text' => "News #$id"]);
        }));

        $newsWithIdRoutes->put('/', new ClosureHandler(function (Request $request) {
            return new JsonResponse(['id' => 4, 'text' => $request->request->get('text')]);
        }));
    });
});

$app->before(function (Request $request) {
    // Do something, for example check auth
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
```

## Request Handlers

+ `ClosureHandler`
```php
new ClosureHandler(function(Request $request) {
    return new Response();
}));
```

+ `ControllerHandler`
```php
class Controller {
    public function methodName(Request $request) {
        return new Response('Hello World!');
    }
}
new ClosureHandler(Controller::class, 'methodName');
```

+ `RouteHandler`
```php
class RouteController {
    public function __construct(Request $request) {
        $this->text = $request->request->get('text', 'empty');
    }
    
    public function handle() {
        return new Response('Hello World!');
    }
}
new ClosureHandler(RouteController::class);
```

## Namespaces
```php
$routeProvider->namespace('/path', function(RequestProvider $pathRoutes) {
    // $pathRoutes->get('/', SomeHandler);
    // $pathRoutes->post('/', SomeHandler);
    
    $routeProvider->namespace('/anotherPath', function(RequestProvider $pathRoutes) {
        $pathRoutes->put('/', SomeHandler);
        $pathRoutes->delete('/', SomeHandler);
    }
}));
```

## Path regex
```php
$routeProvider->get('/api/{uriParameterNameWithRegex=\d+}/{randomUriParameterWithoutRegex}', SomeHandler);
```