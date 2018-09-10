<?php

namespace Apiate\Config;

use Apiate\Resource\ResourceInterface;
use Symfony\Component\Yaml\Yaml;

class ConfigFactory
{
    /**
     * @param string $pathToYaml
     * @return Config
     */
    public static function createFromYaml(string $pathToYaml): Config
    {
        $configArray = Yaml::parseFile($pathToYaml);

        self::validateConfigArray($configArray);

        return self::createConfigFromArray($configArray);
    }

    /**
     * @param array $configArray
     * @return Config
     */
    public static function createFromArray(array $configArray): Config
    {
        self::validateConfigArray($configArray);

        return self::createConfigFromArray($configArray);
    }

    /**
     * @param array $configArray
     * @return Config
     */
    private static function createConfigFromArray(array $configArray): Config
    {
        $resources = [];
        foreach ($configArray['resources'] as $item) {
            $resources[] = new ResourceConfig($item['path'], $item['method'], $item['class']);
        }

        return new Config($resources);
    }

    /**
     * @param array $config
     */
    private static function validateConfigArray(array $config): void
    {
        if ( ! array_key_exists('resources', $config)) {
            throw new InvalidConfigException();
        }

        foreach ($config['resources'] as $resourceName => $item) {
            if ( ! array_key_exists('path', $item)) {
                throw InvalidConfigException::createResourceDoesNotContainsRequiredField($resourceName, 'path');
            }
            if ( ! array_key_exists('method', $item)) {
                throw InvalidConfigException::createResourceDoesNotContainsRequiredField($resourceName, 'method');
            }
            if ( ! array_key_exists('class', $item)) {
                throw InvalidConfigException::createResourceDoesNotContainsRequiredField($resourceName, 'class');
            }

            $class = $item['class'];

            if ( ! class_exists($class)) {
                throw InvalidConfigException::createResourceClassDoesNotExistsException($item['class']);
            }

            if ( ! is_subclass_of($class, ResourceInterface::class)) {
                throw InvalidConfigException::createResourceClassDoesNotImplementsResourceInterfaceException($item['class']);
            }
        }
    }
}