<?php

require_once('app/config/Config.php');

foreach (glob(APPPATH.'helpers/*.php') as $file) {
    require_once $file;
}

spl_autoload_register(function ($className) {
    $path = str_replace('\\', '/', $className) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});
