<?php
require_once 'config.php';
require_once 'db.php';
require_once 'User.php';

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
     * Получить роль
     *
     * @return string
     */
    public function getRole()
    {
        if (isset($_SESSION['login']))
            return $_SESSION['role'];

        return 'guest';
    }

    public function getName() {
        if (isset($_SESSION['login']))
            return $_SESSION['login'];

        return "";
    }

    public function isLogged() {
        return $this->getRole() !== 'guest';
    }

    /**
     * Аутентификация пользователя
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login($login, $password)
    {
        $db = Db::getDBO();
        try {
            $user = $db->getFirst("SELECT u.login, u.password, r.role FROM users u JOIN roles r ON u.role_id = r.id AND login = ?", [$login], PDO::FETCH_CLASS, 'User');
        } catch (Exception $e) {
            throw new Exception("Произошла неизвестная ошибка");
        }

        if ($user) {
            if (!password_verify($password, $user->password))
                throw new Exception('Логин или пароль неверны');

            $_SESSION['login'] = $user->login;
            $_SESSION['role'] = $user->role;
            return true;
        }

        throw new Exception('Логин или пароль неверны');
    }

    public function register($login, $password, $role = 'user')
    {
        $db = Db::getDBO();
        if (!preg_match('/^[a-z0-9_-]{3,12}$/iu', $login))
            throw new Exception('Логин должен быть от 3 до 12 символов и использовать латинский алфавит или цифры');

        if (!preg_match('/^[a-z0-9_-]{3,20}$/iu', $password))
            throw new Exception('Пароль должен быть от 3 до 20 символов и использовать латинский алфавит или цифры');

        try {
            $existingUser = $db->getFirst('SELECT id FROM users WHERE login = ?', [$login]);
            if ($existingUser)
                throw new Exception('Пользователь с таким логином уже существует');

            $roleId = $db->getFirst("SELECT id FROM roles WHERE role = ?", [$role], PDO::FETCH_OBJ)->id;
            $db->query("INSERT INTO users (login, password, role_id) VALUES (?, ?, ?)", [$login, password_hash($password, PASSWORD_DEFAULT), $roleId]);
        } catch (PDOException $e) {
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
