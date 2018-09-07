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

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function handleRequest(Request $request): void
    {
        $resource = $this->getResourceByRequest($request);

        if ($resource === null) {
            throw new Exception("Resource not found for {$request->getRealMethod()} {$request->getRequestUri()}");
        }

        $response = $this->getResponseByResource($resource);

        $response->prepare($request);

        $response->send();
    }

    /**
     * @param ResourceInterface $resource
     * @return Response
     */
    private function getResponseByResource(ResourceInterface $resource): Response
    {
        try {
            $response = $resource->handle();
        } catch (Exception $exception) {
            // @todo handle middleware
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return ResourceInterface|null
     */
    private function getResourceByRequest(Request $request): ?ResourceInterface
    {
        $configResources = $this->config->getResources();

        $resource = null;
        foreach ($configResources as $name => $item) {
            $isResourcePathMatch = preg_match($item->getPath(), $request->getRequestUri()) === 1;
            $isResourceMethodMatch = preg_match($item->getMethod(), $request->getRealMethod()) === 1;

            if ($isResourcePathMatch && $isResourceMethodMatch) {
                $resourceClass = $item->getClass();

                if ( ! class_exists($resourceClass) || ! $resourceClass instanceof ResourceInterface) {
                    throw new InvalidResourceClassException();
                }

                /** @var ResourceInterface $resource */
                $resource = new $resourceClass($request);
                break;
            }
        }

        return $resource;
    }
}