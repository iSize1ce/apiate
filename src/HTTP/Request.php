<?php

namespace Apiate\HTTP;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT = 'PUT';

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uriPath;

    /**
     * @var string
     */
    private $protocolVersion;

    /**
     * @var Parameters
     */
    private $headers;

    /**
     * @var Parameters
     */
    private $cookies;

    /**
     * @var Parameters
     */
    private $uriParameters;

    public function __construct(string $method, string $uri, string $protocolVersion, Parameters $headers, Parameters $cookies)
    {
        $this->method = $method;
        $this->uriPath = $uri;
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->uriParameters = new Parameters();
    }

    public static function createFromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $protocol = substr($_SERVER['SERVER_PROTOCOL'], 5); // @todo exists? default? float?

        $headers = new Parameters(); // @todo host?
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                if ($key !== 'HTTP_COOKIE') {
                    $headers->offsetSet(substr($key, 5), $value);
                }
            }
        }

        $cookies = new Parameters();
        foreach ($_COOKIE as $key => $value) {
            $cookies->offsetSet($key, $value);
        }

        return new self(
            $method,
            $uri,
            $protocol,
            $headers,
            $cookies
        );
    }


    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUriPath(): string
    {
        return $this->uriPath;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function getHeaders(): Parameters
    {
        return $this->headers;
    }

    public function getCookies(): Parameters
    {
        return $this->cookies;
    }

    public function getUriParameters(): Parameters
    {
        return $this->uriParameters;
    }
}