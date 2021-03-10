<?php

require_once('application/config/Config.php');

// foreach (glob(APPPATH.'services/*.php') as $file) {
//     require_once $file;
// }

// foreach (glob(APPPATH.'helpers/*.php') as $file) {
//     require_once $file;
// }

// foreach (glob(APPPATH.'core/*.php') as $file) {
//     require_once $file;
// }

spl_autoload_register(function ($className) {
    // $sources = array(APPPATH."controllers/$className.php", APPPATH."interfaces/$className.php", APPPATH."models/$className.php");

    // var_dump($sources);
    // foreach ($sources as $source) {
    //     if (file_exists($source)) {
    //         require_once $source;
    //     } 
    // } 
    $path = str_replace('\\', '/', $className) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});
