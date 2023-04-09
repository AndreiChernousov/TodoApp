<?php

require_once '../autoload.php';

App\Database::createTable('todo_items', [
    'id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name VARCHAR(255) NOT NULL',
    'email VARCHAR(255) NOT NULL',
    'status VARCHAR(255) NOT NULL',
    'description TEXT NOT NULL',
    'edited TINYINT(1) NOT NULL DEFAULT 0',
    'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP']
);