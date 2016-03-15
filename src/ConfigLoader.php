<?php

namespace Nurmanhabib\Kewilayahan;

use Illuminate\Support\Collection;

class ConfigLoader
{
    private static $loaded = false;
    private static $config = [];

    private function __construct($config = [])
    {
        self::loadOriginal();
        
        $this->appends($config);
    }

    public static function load($config = [])
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new static($config);
        }

        return $instance;
    }

    public function appends($config)
    {
        if (self::$loaded) {
            if ($config instanceof Collection) {
                $config = $config->toArray();
            }

            self::loadCustom($config);
        }

        return $this;
    }

    public function toArray()
    {
        return self::$config;
    }

    public static function loadCustom($config)
    {
        self::$config = array_merge_recursive(self::$config, $config);
    }

    public static function loadOriginal()
    {
        if (self::$loaded === false) {
            $original = __DIR__.'/../config/config.php';

            if (file_exists($original)) {
                $config         = require($original);
                
                self::$config   = $config;
                self::$loaded   = true;
            }
        }
    }
}