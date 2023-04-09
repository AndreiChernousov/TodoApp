<?php

namespace App\Controllers;

use App\Helper;

class AuthUserController extends AbstractController
{
    public function auth() : void
    {
        if($this->user->isAuthorized()) {
            $this->view('logoutUser', ['user' => $this->user->getCurUserData()]);
        }
        else {
            $action = Helper::filterString($_REQUEST['action']);
            $login = Helper::filterString($_REQUEST['login']);
            $password = Helper::filterString($_REQUEST['password']);

            $error = [];
            $success = false;

            // @todo: add validation method to AbstractController

            if ($action === 'login') {

                if (empty($login)) {
                    $error['login'] = 'Login is empty';
                }
                if (empty($password)) {
                    $error['password'] = 'Password is empty';
                }
                if (empty($error)) {
                    $success = $this->user->authUser($login, $password);
                    if(!$success) {
                        $error['auth'] = 'Login or password is incorrect';
                    }
                }

                if($success) {
                    $this->view('logoutUser', ['user' => $this->user->getCurUserData()]);
                    return;
                }
            }

            $this->view('authUser', ['success' => $success, 'error' => $error]);

        }
    }
    public function logout() : void
    {
        $this->user->logoutUser();
        header('Location: ../');
    }
}