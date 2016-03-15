<?php

namespace Nurmanhabib\Kewilayahan\Factories;

use ReflectionClass;
use Nurmanhabib\Kewilayahan\ConfigLoader;
use Nurmanhabib\Kewilayahan\Contracts\OutputContract;
use Illuminate\Contracts\Container\Container\Application;

class OutputFactory
{
    public static function make($type, array $params = [])
    {
        if ($type instanceof OutputContract) {
            return $type;
        }

        $config     = ConfigLoader::load()->toArray();
        $output     = $config['outputs'];
        $class      = $output[$type];
        $instance   = new ReflectionClass($class);
        
        return $instance->newInstanceArgs($params);
    }
}