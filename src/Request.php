<?php

namespace Apiate;

class Request
{
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';
    const METHOD_TRACE = 'TRACE';
    const METHOD_POST = 'POST';
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';

    public static function createFromGlobals(): self
    {
        // TODO
    }

    public function getPost(): ImmutableParams
    {
        // TODO
    }
}