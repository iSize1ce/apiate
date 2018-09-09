## Resource

```php
# src/Resource/ExampleResource.php

class ExampleResource implements ResourceInterface
{
    private $someData;

    public function __construct(Request $request)
    {
        $this->someData = $request->get('query');
    }

    public function handle(): Response
    {
        return new JsonResponse("Hello world by $this->someData");
    }
}
```

## Entrypoint

```php
# public/index.php

require_once __DIR__ . '/../../vendor/autoload.php';

$config = ConfigFactory::createFromYaml(__DIR__ . '/config.yml');

$apiate = new Apiate($config);

$request = Request::createFromGlobals();

try {
    $response = $apiate->getResponseByRequest($request);
} catch (Exception $exception) {
    $apiate->sendResponse(new JsonResponse(['error' => $exception->getMessage()], 500));
}

if ($response !== null) {
    $apiate->sendResponse($response);
}
else {
    $apiate->sendResponse(new JsonResponse(null, 404));
}

exit();
```

## Config

```yaml
resources:
  getExample:
    path: '/example\/(?<id>\d)/'
    method: "/GET/"
    class: 'ExampleResource'
  home:
    path: '/\//'
    method: "/POST|GET/"
    class: 'HomeResource'
```