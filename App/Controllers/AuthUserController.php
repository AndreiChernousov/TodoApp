<?php

namespace App\Controllers;

class AuthUserController extends AbstractController
{
    public function auth() : void
    {
        if($this->user->isAuthorized()) {
            $this->view('logoutUser', ['user' => $this->user->getCurUserData()]);
        }
        else {
            $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_EMAIL);
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

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