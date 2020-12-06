<?php

namespace App;
use Illuminate\Support\Arr;

class CartridgeConfig {
    private static $config = null;

    public static function get($key, $default_value = null) {
        if(static::$config == null) {
            static::$config = Arr::dot(json_decode(file_get_contents(base_path('config.json')), true));
        }

        return static::$config[$key] ?? $default_value;
    }
}