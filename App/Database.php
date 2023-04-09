<?php
namespace App;

class Database
{
    private static $instance = null;
    private \PDO $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new \PDO('mysql:' . Settings::DB_HOST . ';dbname=' . Settings::DB_NAME, Settings::DB_USER, Settings::DB_PASS);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance() : self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() : \PDO
    {
        return $this->pdo;
    }

    public static function createTable(string $table, array $columns) : void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' (';
        foreach ($columns as $column) {
            $sql .= $column . ', ';
        }
        $sql = rtrim($sql, ', ');
        $sql .= ')';
        self::getInstance()->pdo->query($sql);
    }
}