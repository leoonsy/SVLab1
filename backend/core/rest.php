<?php
//инициализация массивов $_PUT и $_POST
$_PUT = [];
$_DELETE = [];

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    $_PUT = getFormData('PUT');

if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    $_DELETE = getFormData('DELETE');

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
