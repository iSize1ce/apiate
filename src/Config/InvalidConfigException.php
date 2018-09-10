<?php

namespace Apiate\Config;

use Apiate\Resource\ResourceInterface;

class InvalidConfigException extends \Exception
{
    /**
     * @param string $resourceClass
     * @return InvalidConfigException
     */
    public static function createResourceClassDoesNotExistsException(string $resourceClass): InvalidConfigException
    {
        return new self("Class \"$resourceClass\" does not exists");
    }

    /**
     * @param string $resourceClass
     * @return InvalidConfigException
     */
    public static function createResourceClassDoesNotImplementsResourceInterfaceException(string $resourceClass): InvalidConfigException
    {
        $resourceInterfaceClass = ResourceInterface::class;

        return new self("Class \"$resourceClass\" does not implements \"$resourceInterfaceClass\"");
    }

    /**
     * @param string|int $resourceName
     * @param string $requiredField
     * @return InvalidConfigException
     */
    public static function createResourceDoesNotContainsRequiredField($resourceName, string $requiredField): InvalidConfigException
    {
        return new self("Resource \"$resourceName\" does not contains required field \"$requiredField\"");
    }
}