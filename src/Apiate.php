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

    public function getResponseByRequest(Request $request)
    {
        $resource = $this->getResourceByRequest($request);

        if ($resource === null) {
            return $resource;
        }

        $response = $resource->handle();

        return $response;
    }

    /**
     * @param Response $response
     * @param Request|null $request
     * @return void
     */
    public function sendResponse(Response $response, Request $request = null): void
    {
        if ($request !== null) {
            $response->prepare($request);
        }

        $response->send();
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