<?php
//инициализация массивов $_PUT и $_POST
$_PUT = [];
$_DELETE = [];

$contentType = getContentType();
if ($contentType == 'application/json') {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST = json_decode(file_get_contents("php://input"), true);
            break;

        case 'DELETE':
            $_DELETE = json_decode(file_get_contents("php://input"), true);
            break;

        case 'PUT':
            $_PUT = json_decode(file_get_contents("php://input"), true);
            break;
    }
}

if ($contentType == 'application/x-www-form-urlencoded') {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'DELETE':
            $_DELETE = getFormData('DELETE');
            break;

        case 'PUT':
            $_PUT = getFormData('PUT');
            break;
    }
}

/**
 * Определить Content-Type
 *
 * @return void
 */
function getContentType()
{
    $headers = getallheaders();
    $contentType = $headers['Content-Type'] ?? null;
    if ($contentType) {
        if (strpos($contentType, 'application/json') !== false)
            return 'application/json';
        if (strpos($contentType, 'application/x-www-form-urlencoded') !== false)
            return 'application/x-www-form-urlencoded';
        if (strpos($contentType, 'multipart/form-data') !== false)
            return 'multipart/form-data';
    }
    return false;
}

/**
 * Получить массив с данными из application/x-www-form-urlencoded
 *
 * @param string $method
 * @return array
 */
function getFormData($method)
{
    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') return $_GET;
    if ($method === 'POST') return $_POST;

    // PUT или DELETE
    $data = [];
    $exploded = explode('&', file_get_contents('php://input'));

    foreach ($exploded as $pair) {
        $item = explode('=', $pair);
        if (count($item) == 2)
            $data[urldecode($item[0])] = urldecode($item[1]);
    }

    return $data;
}
