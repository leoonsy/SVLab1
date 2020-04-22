<?php

header('Content-Type: application/json');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'None'
]);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    sendResponse(['success' => false, 'message' => 'Отсутствует заголовок HTTP_X_REQUESTED_WITH']);

/**
 * Ответ в виде json
 *
 * @param bool $error
 * @param array $data
 * @return void
 */
function sendResponse($data)
{
    echo json_encode($data);
    exit(0);
}
