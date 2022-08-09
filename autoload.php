<?php

spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/entities/' . $class . '.php')) {
        require_once(__DIR__ . '/entities/' . $class . '.php');
    }
});

require_once __DIR__ . '/vendor/autoload.php';
