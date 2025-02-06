<?php
namespace app\model;
require_once __DIR__ . '/../core/Database.php';
use InvalidArgumentException;
use app\core\Database;
use PDOException;
use Exception;
use PDO;
class Crud
{
    private static $db;

    public static function setDb($db)
    {
        self::$db = $db;
    }

    public static function init()
    {
        if (self::$db === null) {
            $database = Database::getInstance();
            self::$db = $database->connect();
            if (!self::$db) {
                throw new Exception("Failed to connect to the database.");
            }
        }
    }

    public static function insertData(string $table, array $data)
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data array cannot be empty.");
        }
        self::init(); 
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $values = array_values($data);
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = self::$db->prepare($sql);
        if ($stmt->execute($values)) {
            return self::$db->lastInsertId();
        } else {
            return false;
        }
    }

    public static function getAll(string $table)
    {
        self::init();

        try {
            $sql = "SELECT * FROM {$table}";
            $stmt = self::$db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Crud::getAll error for table $table: " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération des données");
        }
    }

    public static function getBy(string $table, string $column, $value)
    {
        self::init();

        $sql = "SELECT * FROM {$table} WHERE {$column} = ?";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function getAllBy(string $table, string $column, $value)
    {
        self::init();

        $sql = "SELECT * FROM {$table} WHERE {$column} = ?";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public static function updateData(string $table, array $data, string $identifierColumn, $identifierValue)
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data array cannot be empty.");
        }
        self::init();

        $setClause = implode(", ", array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $values = array_values($data); // Fixed: Changed array.values() to array_values()
        $values[] = $identifierValue;
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$identifierColumn} = ?";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute($values);
    }

    public static function updateColumn(string $table, string $column, mixed $value, string $idColumn, mixed $idValue)
    {
        self::init();

        try {
            $table = htmlspecialchars($table);
            $column = htmlspecialchars($column);
            $idColumn = htmlspecialchars($idColumn);
            $sql = "UPDATE {$table} SET {$column} = ? WHERE {$idColumn} = ?";
            $stmt = self::$db->prepare($sql);
            $result = $stmt->execute([$value, $idValue]);
            return $result;
        } catch (PDOException $e) {
            error_log("Crud::updateColumn error: " . $e->getMessage());
            throw new Exception("Erreur lors de la mise à jour");
        }
    }

    public static function updateStatut(string $table, mixed $statutValue, string $idColumn, mixed $idValue)
    {
        self::init();

        $table = htmlspecialchars($table);
        $idColumn = htmlspecialchars($idColumn);
        $sql = "UPDATE {$table} SET statut = ? WHERE {$idColumn} = ?";
        $stmt = self::$db->prepare($sql);
        $result = $stmt->execute([$statutValue, $idValue]);
        return $result;
    }

    public static function deleteData(string $table, string $identifierColumn, $identifierValue)
    {
        self::init();

        $sql = "DELETE FROM {$table} WHERE {$identifierColumn} = ?";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([$identifierValue]);
    }

    public static function countRecords(string $table)
    {
        self::init();
        try {
            $sql = "SELECT COUNT(*) AS total FROM {$table}";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error in countRecords: " . $e->getMessage());
            return 0;
        }
    }
    public static function countRecordsBy(string $table, string $column, $value)
    {
        self::init();
        try {
            $sql = "SELECT COUNT(*) AS total FROM {$table} WHERE {$column} = ?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$value]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error in countRecordsBy: " . $e->getMessage());
            return 0;
        }
    }

    public static function getPaginated(string $table, int $limit, int $page = 1)
    {
        self::init();
        try {
            $offset = ($page - 1) * $limit;
            $sql = "SELECT * FROM {$table} LIMIT :offset, :limit";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getPaginated: " . $e->getMessage());
            return [];
        }
    }
}