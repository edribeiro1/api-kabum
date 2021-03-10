<?php

require_once('Response.php');

class Router
{
    public static function resolve()
    {
        $uri = Router::uri();
        if (count($uri) && !is_numeric($uri[0])) {
            $param = null;
            $pathModule = "";

            if (is_numeric($uri[count($uri)-1])) {
                $param = (int)$uri[count($uri)-1];
                unset($uri[count($uri)-1]);
            }

            $uri[count($uri)-1] = ucfirst($uri[count($uri)-1]);
            $pathModule = implode($uri, '/');

            var_dump($pathModule);
            exit();
            if (file_exists("../controllers/$pathModule.php")) {
                require_once("../controllers/$pathModule.php");
            } else {
                Response::send(404, false, 'Module not found');
            }
        } else {
            Response::send(
                200,
                true,
                'Api processo seletivo KaBuM!',
                [
                'description' => 'API KaBuM',
                'documentation' => ''
            ]
            );
        }
        // if (count($uri)) {
        // }

        // $controller = $uri[0];
        // $action = $uri[count($uri)-1];
        // var_dump($action);
    }


    // Function to handle the url to avoid module names equal to the base url
    public static function uri()
    {
        $baseUrl = $_SERVER['HTTP_HOST'];
        $baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        $uri = strtolower($_SERVER['REQUEST_URI']);
        $pos = strpos($uri, '?');
        if ($pos) {
            $uri = substr($uri, 0, $pos);
        }

        $baseUrlExplode = explode('/', strtolower($baseUrl));
        $uriExplode = explode('/', $uri);

        $baseUrlExplode = array_filter($baseUrlExplode);
        $uriExplode = array_filter($uriExplode);

        foreach ($uriExplode as $key => $arg) {
            if (in_array($arg, $baseUrlExplode)) {
                unset($uriExplode[$key]);
            }
        }

        return array_values($uriExplode); //array_values ​​to correct array positions
    }
}
