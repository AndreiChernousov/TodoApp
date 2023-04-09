<?php

namespace App\Controllers;

use App\Models\UserModel;

abstract class AbstractController
{
    protected UserModel $user;

    public function __construct()
    {
        session_start();
        $this->user = new UserModel();
    }
    
    protected function view(string $template, array $data) : void
    {
        $user = $this->user->getCurUserData()??[];
        extract($data);
        include '../templates/'.$template.'.php';
    }
}