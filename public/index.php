<?php
require_once '../autoload.php';

(new App\Router())->addRoutes([
    ['pattern' => '', 'controller' => 'TodoList', 'action' => 'index'],
    ['pattern' => '/todo', 'controller' => 'TodoList', 'action' => 'index'],
    ['pattern' => '/todo/completed', 'controller' => 'TodoList', 'action' => 'completed'],
    ['pattern' => '/todo/edit', 'controller' => 'TodoList', 'action' => 'edit'],
    ['pattern' => '/auth', 'controller' => 'AuthUser', 'action' => 'auth'],
    ['pattern' => '/logout', 'controller' => 'AuthUser', 'action' => 'logout'],
])->run();
