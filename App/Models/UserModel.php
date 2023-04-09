<?php

namespace App\Models;

class UserModel
{
    protected bool $isAdmin = false;
    protected bool $isAuthorized = false;
    protected array $curUserData = [];

    public function __construct()
    {
        // try to auth user
        if (!empty($_SESSION['authUserLogin'])) {
            $curUser = $this->getUser($_SESSION['authUserLogin']);
            if($curUser) {
                $this->initUser($curUser);
            }
        }

    }

    public function authUser(string $login, string $password) : bool
    {
        $user = $this->getUser($login);
        if (empty($user)) {
            return false;
        }
        if (!password_verify($password, $user['password'])) {
            return false;
        }
        $_SESSION['authUserLogin'] = $login;

        $this->initUser($user);

        return true;
    }

    public function logoutUser() : void
    {
        unset($_SESSION['authUserLogin']);
    }

    public function getUser(string $login) : array
    {
        $users = [
            'admin' => ['name' => 'Admin', 'password' => password_hash('123', PASSWORD_DEFAULT), 'isAdmin' => true],
            'anotherUser' => ['name' => 'Andrew', 'password' => password_hash('wsxdqwrf', PASSWORD_DEFAULT), 'isAdmin' => false],
        ];
        return $users[$login] ?? [];
    }

    public function isAdmin() : bool
    {
        return $this->isAdmin;
    }

    public function isAuthorized() : bool
    {
        return $this->isAuthorized;
    }

    public function getCurUserData() : array
    {
        return $this->curUserData;
    }

    protected function initUser(array $curUser) : void{
        $this->isAuthorized = true;
        $this->curUserData = $curUser;
        $this->isAdmin = $curUser['isAdmin'];
    }

}