<?php

use core\Auth;
use core\Notes;
use model\Note;

require_once 'core/autoload.php';
require_once 'core/cors.php';
require_once 'core/rest.php';
require_once 'core/apiCommon.php';

$auth = new Auth();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_GET['action']) {
        case 'getNotes':
            try {
                $notes = Notes::getNotes($auth->getUserId());
                sendResponse(['success' => true, 'data' => $notes]);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_POST['action']) {
        case 'addNote':
            if ($auth->getRole() == 'guest')
                sendResponse(['success' => false, 'message' => 'Требуется авторизация']);

            $note = new Note();
            $note->setNote(null, $auth->getUserId(), '', '', time());

            $insertId = Notes::addNote($note);
            $note->id = $insertId;

            sendResponse(['success' => true, 'data' => $note]);
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if (!isset($_PUT['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_PUT['action']) {
        case 'updateNote':
            $noteId = $_PUT['id'] ?? null;
            if (!$noteId)
                sendResponse(['success' => false, 'message' => 'Неверные входные параметры']);

            $updatedNote = Notes::getNote($noteId);
            if ($updatedNote->userId != $auth->getUserId())
                sendResponse(['success' => false, 'message' => 'Нет прав']);

            $note = new Note();
            $note->setNote($noteId, null, $_PUT['name'] ?? null, $_PUT['description'] ?? null, time());
            Notes::updateNote($note);

            sendResponse(['success' => true]);
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (!isset($_DELETE['action']))
        sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);

    switch ($_DELETE['action']) {
        case 'deleteNote':
            $noteId = $_DELETE['id'] ?? null;
            if (!$noteId)
                sendResponse(['success' => false, 'message' => 'Неверные входные параметры']);

            $deletedNote = Notes::getNote($noteId);
            if ($deletedNote->userId != $auth->getUserId())
                sendResponse(['success' => false, 'message' => 'Нет прав']);

            try {
                Notes::deleteNote($noteId);
            } catch (Exception $e) {
                sendResponse(['success' => false, 'message' => $e->getMessage()]);
            }

            sendResponse(['success' => true]);
            break;
    }
}

sendResponse(['success' => false, 'message' => 'Неверные параметры запроса']);
