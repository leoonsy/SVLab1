<?php

namespace core;

use core\Config;
use core\Db;
use model\User;
use Exception;
use PDO;

class Auth
{
    public function __construct()
    {
        session_start();
    }

    /**
     * Получить доступные для роли страницы
     *
     * @param string $role
     * @return array
     */
    public function getAccessPages($role)
    {
        $accessPages = require_once 'acl/pages.php';
        return $accessPages[$role];
    }

    /**
     * Получить id текущего пользователя
     *
     * @return int|bool
     */
    public function getUserId()
    {
        if (isset($_SESSION['id']))
            return $_SESSION['id'];

        return null;
    }

    /**
     * Получить роль
     *
     * @return string
     */
    public function getRole()
    {
        if (isset($_SESSION['username']))
            return $_SESSION['role'];

        return 'guest';
    }

    public function getUsername()
    {
        if (isset($_SESSION['username']))
            return $_SESSION['username'];

        return null;
    }

    public function isLogged()
    {
        return $this->getRole() !== 'guest';
    }

    /**
     * Аутентификация пользователя
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password)
    {
        $db = Db::getDBO();
        try {
            $user = $db->getFirst("SELECT u.id, u.username, u.password, r.role FROM users u JOIN roles r ON u.role_id = r.id AND username = ?", [$username], PDO::FETCH_CLASS, 'model\User');
        } catch (Exception $e) {
            throw new Exception("Произошла неизвестная ошибка");
        }

        if ($user) {
            if (!password_verify($password, $user->password))
                throw new Exception('Логин или пароль неверны');

            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            return true;
        }

        throw new Exception('Логин или пароль неверны');
    }

    public function register($username, $password, $role = 'user')
    {
        $db = Db::getDBO();
        if (!preg_match('/^[a-z0-9_-]{3,12}$/iu', $username))
            throw new Exception('Логин должен быть от 3 до 12 символов и использовать латинский алфавит или цифры');

        if (!preg_match('/^[a-z0-9_-]{3,20}$/iu', $password))
            throw new Exception('Пароль должен быть от 3 до 20 символов и использовать латинский алфавит или цифры');

        try {
            $existingUser = $db->getFirst('SELECT id FROM users WHERE username = ?', [$username]);
        } catch (Exception $e) {
            throw new Exception("Неизвестная ошибка");
        }

        if ($existingUser)
            throw new Exception('Пользователь с таким логином уже существует');
        try {
            $roleId = $db->getFirst("SELECT id FROM roles WHERE role = ?", [$role], PDO::FETCH_OBJ)->id;
            $db->exec("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)", [$username, password_hash($password, PASSWORD_DEFAULT), $roleId]);
        } catch (Exception $e) {
            throw new Exception("Неизвестная ошибка");
        }
    }

    /**
     * Уничтожение сессии (выход)
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
    }
}
