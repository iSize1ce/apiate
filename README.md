# Apiate

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
class MyRequestHandler implements RouteRequestHandler {
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
    $pathRoutes->get('/', SomeHandler);
    $pathRoutes->post('/', SomeHandler);
    
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
