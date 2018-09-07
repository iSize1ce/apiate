<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Config\ConfigFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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