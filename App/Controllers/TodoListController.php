<?php

namespace App\Controllers;

use App\Helper;
use App\Models\TodoItemModel;

class TodoListController extends AbstractController
{
    protected function create() : array
    {
        $result = [];

        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $name = Helper::filterString($_REQUEST['name']);
        $description = Helper::filterString($_REQUEST['description']);

        // @todo: add validation method to AbstractController
        if(empty($email)) {
            $result['error']['email'] = 'Email is empty';
        }
        if(empty($name)) {
            $result['error']['name'] = 'Name is empty';
        }
        if(empty($description)) {
            $result['error']['description'] = 'Description is empty';
        }

        $emailRegex = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
        if(!empty($email) && !preg_match($emailRegex, $email)) {
            $result['error']['email'] = 'Email is not valid';
        }

        if(empty($result['error'])) {
            $result['createItem'] = (new TodoItemModel())->createItem($name, $email, $description);
        }

        return $result;
    }
    public function index() : void
    {
        $result = [];

        if(isset($_POST['action']) && $_POST['action'] === 'createItem') {
            $result = $this->create();
        }

        $page = Helper::getCurPage();
        $sortBy = Helper::getSortBy();
        $sortOrder = Helper::getSortOrder();

        $result = array_merge($result, (new TodoItemModel())->getItems($page, $sortBy, $sortOrder));

        $result['sort'] = ['sortBy' => $sortBy, 'sortOrder' => $sortOrder];

        $this->view('todoList', $result);
    }

    public function completed() : void
    {
        $result = [];

        if($this->user->isAdmin() === false) {
            $result = ['success' => false, 'error' => 'You are not allowed to do this'];
        }
        else {
            $id = Helper::filterInt($_REQUEST['id']);

            if (!empty($id)) {
                $result['success'] = (new TodoItemModel())->updateStatus($id, TodoItemModel::STATUS_DONE);
            }
        }

        $this->view('jsonCompleted', $result);
    }
    public function edit() : void
    {
        $result = [];

        if($this->user->isAdmin() === false) {
            $result = ['success' => false, 'error' => 'You are not allowed to do this'];
        }
        else {
            $id = Helper::filterInt($_REQUEST['id']);
            $description = Helper::filterString($_REQUEST['description']);

            if (!empty($id)) {
                $result['success'] = (new TodoItemModel())->updateItem($id, $description);
            }
        }
        $this->view('jsonEdit', $result);
    }

}