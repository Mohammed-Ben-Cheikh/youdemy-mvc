<?php
require_once __DIR__ . "/../../vendor/autoload.php";
use App\Model\Crud;

try {
    echo 'test';
    $table = 'your_table_name';
    $data = [
        'column1' => 'value1',
        'column2' => 'value2',
        // Add more columns and values as needed
    ];
    $insertId = Crud::insertData($table, $data);
    echo "Inserted record ID: " . $insertId . PHP_EOL;
} catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . PHP_EOL;
}

// Test getAll method
try {
    $table = 'your_table_name';
    $records = Crud::getAll($table);
    echo "All records: " . print_r($records, true) . PHP_EOL;
} catch (Exception $e) {
    echo "Error fetching all records: " . $e->getMessage() . PHP_EOL;
}

// Test getBy method
try {
    $table = 'your_table_name';
    $column = 'column1';
    $value = 'value1';
    $record = Crud::getBy($table, $column, $value);
    echo "Record by column: " . print_r($record, true) . PHP_EOL;
} catch (Exception $e) {
    echo "Error fetching record by column: " . $e->getMessage() . PHP_EOL;
}

// Test updateData method
try {
    $table = 'your_table_name';
    $data = [
        'column1' => 'new_value1',
        'column2' => 'new_value2',
        // Add more columns and values as needed
    ];
    $identifierColumn = 'id';
    $identifierValue = 1; // Change to the ID of the record you want to update
    $isUpdated = Crud::updateData($table, $data, $identifierColumn, $identifierValue);
    echo "Record updated: " . ($isUpdated ? 'Yes' : 'No') . PHP_EOL;
} catch (Exception $e) {
    echo "Error updating data: " . $e->getMessage() . PHP_EOL;
}

// Test deleteData method
try {
    $table = 'your_table_name';
    $identifierColumn = 'id';
    $identifierValue = 1; // Change to the ID of the record you want to delete
    $isDeleted = Crud::deleteData($table, $identifierColumn, $identifierValue);
    echo "Record deleted: " . ($isDeleted ? 'Yes' : 'No') . PHP_EOL;
} catch (Exception $e) {
    echo "Error deleting data: " . $e->getMessage() . PHP_EOL;
}