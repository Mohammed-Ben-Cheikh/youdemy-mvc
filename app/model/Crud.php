<?php
namespace app\model;

use app\core\Database;
use PDO;
use PDOException;
use InvalidArgumentException;

class Crud
{
    private static $db;

    public static function initialize(): void
    {
        if (self::$db === null) {
            self::$db = Database::getInstance()->getConnection();
        }
    }

    public static function insertData(string $table, array $data): int
    {
        self::validateTableName($table);
        self::validateData($data);

        self::initialize();
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        try {
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
            $stmt = self::$db->prepare($sql);
            $stmt->execute($data);
            return (int)self::$db->lastInsertId();
        } catch (PDOException $e) {
            self::handleException($e, "insertData");
            throw $e;
        }
    }

    public static function getAll(string $table): array
    {
        self::validateTableName($table);
        self::initialize();

        try {
            $stmt = self::$db->query("SELECT * FROM {$table}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            self::handleException($e, "getAll");
            throw $e;
        }
    }

    public static function getBy(string $table, string $column, $value): ?array
    {
        self::validateTableName($table);
        self::validateColumnName($column);
        self::initialize();

        try {
            $stmt = self::$db->prepare("SELECT * FROM {$table} WHERE {$column} = ?");
            $stmt->execute([$value]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            self::handleException($e, "getBy");
            throw $e;
        }
    }

    public static function updateData(string $table, array $data, string $identifierColumn, $identifierValue): bool
    {
        self::validateTableName($table);
        self::validateColumnName($identifierColumn);
        self::validateData($data);

        self::initialize();

        $setClause = implode(', ', array_map(fn($col) => "{$col} = :{$col}", array_keys($data)));
        $data[$identifierColumn] = $identifierValue;

        try {
            $sql = "UPDATE {$table} SET {$setClause} WHERE {$identifierColumn} = :{$identifierColumn}";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            self::handleException($e, "updateData");
            throw $e;
        }
    }

    public static function deleteData(string $table, string $identifierColumn, $identifierValue): bool
    {
        self::validateTableName($table);
        self::validateColumnName($identifierColumn);
        self::initialize();

        try {
            $stmt = self::$db->prepare("DELETE FROM {$table} WHERE {$identifierColumn} = ?");
            return $stmt->execute([$identifierValue]);
        } catch (PDOException $e) {
            self::handleException($e, "deleteData");
            throw $e;
        }
    }

    public static function updateColumn(string $table, string $column, mixed $value, string $idColumn, mixed $idValue): bool
    {
        self::validateTableName($table);
        self::validateColumnName($column);
        self::validateColumnName($idColumn);
        self::initialize();

        try {
            $sql = "UPDATE {$table} SET {$column} = ? WHERE {$idColumn} = ?";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([$value, $idValue]);
        } catch (PDOException $e) {
            self::handleException($e, "updateColumn");
            throw $e;
        }
    }

    public static function updateStatut(string $table, mixed $statutValue, string $idColumn, mixed $idValue): bool
    {
        self::validateTableName($table);
        self::validateColumnName($idColumn);
        self::initialize();

        try {
            $sql = "UPDATE {$table} SET statut = ? WHERE {$idColumn} = ?";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute([$statutValue, $idValue]);
        } catch (PDOException $e) {
            self::handleException($e, "updateStatut");
            throw $e;
        }
    }

    public static function countRecords(string $table): int
    {
        self::validateTableName($table);
        self::initialize();

        try {
            $sql = "SELECT COUNT(*) AS total FROM {$table}";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($result['total'] ?? 0);
        } catch (PDOException $e) {
            self::handleException($e, "countRecords");
            throw $e;
        }
    }

    public static function countRecordsBy(string $table, string $column, $value): int
    {
        self::validateTableName($table);
        self::validateColumnName($column);
        self::initialize();

        try {
            $sql = "SELECT COUNT(*) AS total FROM {$table} WHERE {$column} = ?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$value]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($result['total'] ?? 0);
        } catch (PDOException $e) {
            self::handleException($e, "countRecordsBy");
            throw $e;
        }
    }

    public static function getPaginated(string $table, int $limit, int $page = 1): array
    {
        self::validateTableName($table);
        self::initialize();

        try {
            $offset = ($page - 1) * $limit;
            $sql = "SELECT * FROM {$table} LIMIT :offset, :limit";
            $stmt = self::$db->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            self::handleException($e, "getPaginated");
            throw $e;
        }
    }

    // Méthodes de validation
    private static function validateTableName(string $table): void
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table)) {
            throw new InvalidArgumentException("Invalid table name format");
        }
    }

    private static function validateColumnName(string $column): void
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
            throw new InvalidArgumentException("Invalid column name format");
        }
    }

    private static function validateData(array $data): void
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data array cannot be empty");
        }
    }

    private static function handleException(PDOException $e, string $method): void
    {
        $logFile = __DIR__ . "/errors.log"; // Définir le fichier de log
    
        $message = "[" . date("Y-m-d H:i:s") . "] Erreur dans {$method}: " . $e->getMessage() . " | Code SQL: " . $e->getCode() . "\n";
        
        error_log($message, 3, $logFile); // Enregistrer l'erreur dans errors.log
    }
    
}


