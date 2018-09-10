## Resource

```php
# src/Resource/ExampleResource.php

class ExampleResource implements ResourceInterface
{
    private $someData;

    public function __construct(Request $request)
    {
        // May contain validation/translation e.t.c.
        // Set valid properties

        $this->someData = $request->get('query');
    }

    public function handle(): Response
    {
        // Handle Request, send Response

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

// Handle exception in Resource::handle()
try {
    $response = $apiate->getResponseByRequest($request);
} catch (Exception $exception) {
    $response = new JsonResponse(['error' => $exception->getMessage()], 500);
}

// Handle when url does not match with your resources
if ($response === null) {
     $respone = new JsonResponse(null, 404);
}

$apiate->sendResponse($response);

exit();
```

## Config

```yaml
resources:
  getExample:
    # regex, be careful
    path: '/example\/(?<id>\d)/'
    # regex, be careful
    method: "/GET/"
    # php class
    class: 'ExampleResource'
  home:
    path: '/\//'
    method: "/POST|GET/"
    class: 'HomeResource'
```