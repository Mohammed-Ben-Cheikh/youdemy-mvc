<?php
namespace app\core;
use PDOException;
use PDO;
class Database
{
    private $host = "localhost";
    private $db_name = "youdemy";
    private $username = "root";
    private $password = "";
    private $conn = null;
    private $error;

    // Static property to hold the single instance
    private static $instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        $this->connect();
    }

    // Public static method to access the instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to establish the connection
    public function connect()
    {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                error_log("Database connection error: {$this->error}", 0); // Log errors instead of echoing them
                return null;
            }
        }

        return $this->conn;
    }

    // Method to get any errors
    public function getError()
    {
        return $this->error;
    }
}
