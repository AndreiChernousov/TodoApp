<?php
namespace App\Models;

use App\Database;
use App\Settings;

class TodoItemModel
{
    public const STATUS_NEW = 'new';
    public const STATUS_DONE = 'done';
    protected string $table = 'todo_items';
    public function getItems(int $currentPage = 4, string $sortBy = 'id' , $sortOrder = 'desc') : array
    {
        $pagination = Settings::PAGINATION;
        $offset = (string)($currentPage - 1) * $pagination;

        $orderBy = $sortBy . ' ' . $sortOrder;

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM ' . $this->table . ' ORDER BY '.$orderBy.' LIMIT :perPage OFFSET :offset');

        $stmt->bindParam(':perPage', $pagination, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        $data['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Get total number of items
        $stmt = $db->prepare('SELECT COUNT(*) FROM '.$this->table);
        $stmt->execute();
        $total_rows = $stmt->fetchColumn();
        $data['pageTotal'] = ceil($total_rows / $pagination);

        return $data;
    }
    public function createItem(string $name, string $email, string $description) : bool
    {
        $db = Database::getInstance()->getConnection();
        $sql = 'INSERT INTO ' . $this->table . ' (name, email, description, status) VALUES (:name, :email, :description, :status)';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['name' => $name, 'email' => $email, 'description' => $description, 'status' => self::STATUS_NEW]);
    }

    public function updateItem(int $id, string $description) : bool
    {
        $db = Database::getInstance()->getConnection();
        $sql = 'UPDATE ' . $this->table . ' SET description = :description, edited = 1 WHERE id = :id';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id, 'description' => $description]);
    }

    public function updateStatus(int $id, string $status) : bool
    {
        $db = Database::getInstance()->getConnection();
        $sql = 'UPDATE ' . $this->table . ' SET status = :status WHERE id = :id';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
}