<?php

// A somewhat hacky way to pull .json config into Laravel with default values

use \App\CartridgeConfig as Config;

return [
    "scheduler" => [
        "scan" => Config::get('scheduler.scan', '0 * * * *'),
    ],
    
    "file_extension_slugs" => Config::get('file_extension_slugs', [
        "nes"   =>  "nes",
        "snes"  =>  "snes--1",
        "md"    =>  "smd",
        "gba"   =>  "gba"
    ]),

    "allow_registration" => Config::get('allow_registration', false),
    "allow_guests" => Config::get('allow_guests', false)
];