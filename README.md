# Apiate
Lightweight HTTP API microframework which use `symfony/http-foundation`

## Installation
``` composer require isize1ce/apiate ```

## Example

```php
class TestResource implements \Resource\ResourceInterface
{
    private $data;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        // Validate
        // Translate
        $this->data = 'world';
    }

    public function handle(): \Symfony\Component\HttpFoundation\Response
    {
        return new \Symfony\Component\HttpFoundation\JsonResponse("Hello $this->data");
    }
}

// You can use yaml ::createFromYaml
$config = \Config\ConfigFactory::createFromArray([
    'resources' => [
        [
            'path' => '/^\/$/',
            'method' => '/GET/',
            'class' => TestResource::class
        ]
    ]
]);

$apiate = new Apiate($config);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

// Handle Resource::handle() exceptions
try {
    $response = $apiate->getResponseByRequest($request);
} catch (Exception $exception) {
    $response = new \Symfony\Component\HttpFoundation\JsonResponse(['error' => $exception->getMessage()], 500);
}

// Handle if request url does not match resources path
if ($response === null) {
    $response = new \Symfony\Component\HttpFoundation\JsonResponse(null, 404);
}

$apiate->sendResponse($response);

exit();
```

[Another example](example)