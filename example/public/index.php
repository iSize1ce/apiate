<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/HomeResource.php';
require_once __DIR__ . '/ExampleResource.php';

use Config\ConfigFactory;
use Symfony\Component\HttpFoundation\Request;

$config = ConfigFactory::createFromYaml(__DIR__ . '/config.yml');
$apiate = new Apiate($config);

$request = Request::createFromGlobals();

$apiate->handleRequest($request);

exit();