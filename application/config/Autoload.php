<?php

require_once('application/config/Config.php');

// foreach (glob(APPPATH.'services/*.php') as $file) {
//     require_once $file;
// }

foreach (glob(APPPATH.'helpers/*.php') as $file) {
    require_once $file;
}

spl_autoload_register(function ($className) {
    $path = str_replace('\\', '/', $className) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});
