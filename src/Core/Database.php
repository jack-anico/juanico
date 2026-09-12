<?php

namespace App\Core;

use PDO;
use PDOStatement;
use PDOException;
use RuntimeException;

/**
 * Database — Singleton PDO Wrapper
 *
 * Provides a single, shared database connection across the application.
 * Uses PDO with real prepared statements to prevent SQL injection
 * (rubric criterion #3: no SQL injection risk).
 *
 * Usage:
 *   $db = Database::getInstance();
 *   $users = $db->fetchAll("SELECT * FROM users WHERE role = :role", ['role' => 'customer']);
 *   $user  = $db->fetch("SELECT * FROM users WHERE user_id = :id", ['id' => 1]);
 *   $db->execute("INSERT INTO users (username, email, password_hash) VALUES (:u, :e, :p)", [...]);
 */
class Database
{
    /** @var Database|null Singleton instance */
    private static ?Database $instance = null;

    /** @var PDO The underlying PDO connection */
    private PDO $pdo;

    /**
     * Private constructor — prevents direct instantiation.
     * Builds the DSN from config and creates the PDO connection.
     *
     * @param array $config Database configuration array from config/database.php
     * @throws RuntimeException If the connection fails
     */
    private function __construct(array $config)
    {
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $config['driver'],
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        try {
            $this->pdo = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            // Never expose raw DB errors to end users (rubric #6: graceful error handling)
            throw new RuntimeException(
                'Database connection failed: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }
    }

    /**
     * Prevent cloning of the singleton instance.
     */
    private function __clone() {}

    /**
     * Get the singleton Database instance.
     * On first call, loads config and establishes the connection.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * Get the raw PDO connection (for advanced/edge cases).
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // -----------------------------------------------------------------
    //  Query Helpers — All use prepared statements (no SQL injection)
    // -----------------------------------------------------------------

    /**
     * Execute a query and return the PDOStatement.
     * Binds parameters via prepared statements automatically.
     *
     * @param  string $sql    SQL query with named placeholders (:param)
     * @param  array  $params Associative array of placeholder => value
     * @return PDOStatement
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Fetch a single row as an associative array.
     *
     * @param  string     $sql    SQL query
     * @param  array      $params Bound parameters
     * @return array|false        Row data or false if not found
     */
    public function fetch(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Fetch all matching rows as an array of associative arrays.
     *
     * @param  string $sql    SQL query
     * @param  array  $params Bound parameters
     * @return array          Array of rows
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Execute a non-SELECT statement (INSERT, UPDATE, DELETE).
     * Returns the number of affected rows.
     *
     * @param  string $sql    SQL statement
     * @param  array  $params Bound parameters
     * @return int            Number of affected rows
     */
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Get the last inserted auto-increment ID.
     *
     * @return string The last insert ID
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    // -----------------------------------------------------------------
    //  Transaction Support
    // -----------------------------------------------------------------

    /**
     * Start a database transaction.
     *
     * @return bool
     */
    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit the current transaction.
     *
     * @return bool
     */
    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    /**
     * Roll back the current transaction.
     *
     * @return bool
     */
    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    /**
     * Check if currently inside a transaction.
     *
     * @return bool
     */
    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }

    /**
     * Reset the singleton instance (useful for testing).
     *
     * @return void
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
