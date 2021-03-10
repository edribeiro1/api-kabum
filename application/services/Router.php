<?php

namespace application\services;

class Router
{
    public static function resolve()
    {
        $uri = Router::uri();
        if (count($uri) && !is_numeric($uri[0])) {
            $param = null;
            $pathModule = "";
            $className = null;
            $method = "index";

            if (is_numeric($uri[count($uri)-1])) {
                $param = (int)$uri[count($uri)-1];
                unset($uri[count($uri)-1]);
            }

            foreach ($uri as $directory) {
                if (is_null($className)) {
                    if (file_exists(APPPATH.'controllers/' . $pathModule . ucfirst($directory) . '.php')) {
                        $className = ucfirst($directory);
                        $pathModule .= "$className.php";
                    } else {
                        $pathModule .= "$directory/";
                    }
                } else {
                    $method = $directory;
                }
            }
           
            if ($className) {
                require_once(APPPATH."controllers/$pathModule");

                $class = new $className();
                $class->$method($param);
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
