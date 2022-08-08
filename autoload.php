<?php

spl_autoload_register(function ($class) {
    if (file_exists('entities/' . $class . '.php')) {
        require_once('entities/' . $class . '.php');
    }
});
