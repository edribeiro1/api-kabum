<?php

function camelCaseToSnakeCase($text = "")
{
    $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
    preg_match_all($pattern, trim($text), $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

function validateStrictlyPositiveNumber($number)
{
    if (is_numeric($number) && (int)$number > 0) {
        return true;
    }
    return false;
}

function validateDate($stringDate)
{
    $datetime = DateTime::createFromFormat('Y-m-d', trim($stringDate));
    if ($datetime) {
        return true;
    }
    return false;
}

function validateString($string)
{
    if (is_string($string) && strlen(trim($string)) > 0) {
        return true;
    }
    return false;
}

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
