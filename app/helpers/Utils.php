<?php

// namespace app\helpers;

// class Utils
// {
function method()
{
    return strtoupper($_SERVER['REQUEST_METHOD']);
}

function getContents($paramentro = false)
{
    $contents = null;

    switch (method()) {
    case 'DELETE':
    case 'GET':
        $contents = $_GET;
        break;

    case 'POST':
        $contents = $_POST;
        if (!is_array($contents) || count($contents) <= 0) {
            $contents = json_decode(file_get_contents("php://input"), true);
        }
        break;
        
    case 'PUT':
        $args = file_get_contents("php://input");
        $contents = json_decode($args, true);
        if (!is_array($contents)) {
            parse_str($args, $contents);
        }
        break;
}

    if ($contents && is_array($contents) && count($contents) > 0) {
        if ($paramentro && strlen($paramentro) > 0) {
            if (isset($contents[$paramentro])) {
                return $contents[$paramentro];
            } else {
                return false;
            }
        }
        return $contents;
    }
    return false;
}
// }
