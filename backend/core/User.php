<?php

class User {
    public $login;
    public $password;
    public $role;

    public function setUser($login, $password, $role)
    {
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
    }
}