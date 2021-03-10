<?php

$baseUrl = 'http://';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $baseUrl ='https://';
}
$baseUrl .= $_SERVER['HTTP_HOST'];
$baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

define('BASE_URL', $baseUrl);
define('APPPATH', 'application/');

$envs = parse_ini_file('.env');

foreach ($envs as $key => $value) {
    $_ENV[$key] = $value;
}

if ($_ENV['ENVIRONMENT'] == 'production') {
    ini_set('display_errors', 0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
