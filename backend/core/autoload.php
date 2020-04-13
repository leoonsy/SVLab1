<?php

function classToFile($class, $ext = '.php') {
    $temp = explode('\\', $class);
    $path = implode('/', $temp).$ext;
    return $path;
}

spl_autoload_register(function ($class) {
    $path = classToFile($class);
    if (file_exists($path)) {
        require_once $path;
    }
});