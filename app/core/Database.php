<?php
namespace app\core;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "youdemy";
    private $username = "root";
    private $password = "";
    private $conn = null;

    private static $instance = null;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new \RuntimeException("Database connection failed: Check configuration and server status");
            }
        }
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }

    // Empêcher le clonage et la désérialisation
    private function __clone() {}
    public function __wakeup() {}
}