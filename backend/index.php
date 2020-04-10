<?php
require_once 'core/cors.php';
require_once 'core/rest.php';
require_once 'core/Auth.php';

// header('Content-Type: application/json');

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
    sendResponse(['success' => false, 'message' => 'Отсутствует заголовок HTTP_X_REQUESTED_WITH']);

$auth = new Auth();
$headers = getallheaders();
$contentType = $headers['Content-Type'] ?? null;
if ($contentType && strpos($contentType, 'application/json') !== false) {
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

if (isset($_POST['type'])) {
    switch ($_POST['type']) {
        case 'login':
            if ($auth->isLogged())
                sendResponse(['success' => false, 'message' => 'Вы уже авторизованы']);
            $name = $_POST['name'] ?? null;
            $password = $_POST['password'] ?? null;

            try {
                $auth->login($name, $password);
                sendResponse(['success' => true]);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'register':
            $name = $_POST['name'] ?? null;
            $password = $_POST['password'] ?? null;

            try {
                $auth->register($name, $password);
                sendResponse(['success' => true]);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'userInfo':
            $name = $auth->getName();
            $role = $auth->getRole();
            $accessPages = $auth->getAccessPages($role);
            sendResponse(['success' => true, 'data' => ['name' => $name, 'role' => $role, 'accessPages' => $accessPages]]);
        break;         

        case 'logout':
            $auth->logout();
            sendResponse(['success' => true]);
    }
}

/**
 * Ответ в виде json
 *
 * @param bool $error
 * @param array $data
 * @return void
 */
function sendResponse($data)
{
    $data['success'] = $data['success'] ?? 'false';
    $data['message'] = $data['message'] ?? '';
    $data['data'] = $data['data'] ?? [];
    echo json_encode($data);
    exit(0);
}
