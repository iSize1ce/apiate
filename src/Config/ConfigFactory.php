<?php

namespace Config;

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

        if ( ! array_key_exists('resources', $configArray)) {
            throw new InvalidConfigException();
        }

        $resources = [];
        foreach ($configArray['resources'] as $item) {
            if ( ! array_key_exists('path', $item) || ! array_key_exists('method', $item) || ! array_key_exists('class', $item)) {
                throw new InvalidConfigException();
            }

            $resources[] = new ResourceConfig($item['path'], $item['method'], $item['class']);
        }

        return new Config($resources);
    }
}