<?php

use Config\Config;
use Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Apiate
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function handleRequest(Request $request)
    {
        $configResources = $this->config->getResources();

        $resource = null;
        foreach ($configResources as $name => $item) {
            $isResourcePathMatch = preg_match($item->getPath(), $request->getRequestUri()) === 1;
            $isResourceMethodMatch = preg_match($item->getMethod(), $request->getRealMethod()) === 1;

            if ($isResourcePathMatch && $isResourceMethodMatch) {
                $resourceClass = $item->getClass();

                /** @var ResourceInterface $resource */
                $resource = new $resourceClass($request);
                break;
            }
        }

        if ($resource === null) {
            throw new Exception("Resource not found for {$request->getRealMethod()} {$request->getRequestUri()}");
        }

        $response = $resource->handle();

        $this->handleResponse($request, $response);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    private function handleResponse(Request $request, Response $response)
    {
        $response->prepare($request);
        $response->send();
    }
}