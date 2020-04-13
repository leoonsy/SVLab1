<?php

use core\Auth;

require_once 'core/autoload.php';
require_once 'core/cors.php';
require_once 'core/rest.php';
require_once 'core/apiCommon.php';

$auth = new Auth();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_POST['action']) {
        case 'login':
            if ($auth->isLogged())
                sendResponse(['success' => false, 'message' => 'Вы уже авторизованы']);

            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            if (!$username || !$password)
                sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

            try {
                $auth->login($username, $password);
                sendResponse(['success' => true]);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        case 'register':
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            try {
                $auth->register($username, $password);
                sendResponse(['success' => true]);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_GET['action']) {
        case 'getUserInfo':
            $username = $auth->getUsername();
            $role = $auth->getRole();
            $accessPages = $auth->getAccessPages($role);
            sendResponse(['success' => true, 'data' => ['username' => $username, 'role' => $role, 'accessPages' => $accessPages]]);
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (!isset($_DELETE['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_DELETE['action']) {
        case 'logout':
            $auth->logout();
            sendResponse(['success' => true]);
            break;
    }
}

sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);
