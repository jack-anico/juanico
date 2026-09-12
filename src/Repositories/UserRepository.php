<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

/**
 * UserRepository — Handles database operations for the users table.
 */
class UserRepository implements RepositoryInterface
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findById(int $id): ?array
    {
        $result = $this->db->fetch("SELECT * FROM users WHERE user_id = :id", ['id' => $id]);
        return $result !== false ? $result : null;
    }

    public function findAll(): array
    {
        return $this->db->fetchAll("SELECT * FROM users");
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO users (username, email, password_hash, phone, role) 
                VALUES (:username, :email, :password_hash, :phone, :role)";
        
        $this->db->execute($sql, [
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'] ?? 'customer'
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        // To be implemented if needed
        return false;
    }

    public function delete(int $id): bool
    {
        // To be implemented if needed
        return false;
    }

    /**
     * Domain-specific methods
     */
    public function findByUsername(string $username): ?array
    {
        $result = $this->db->fetch("SELECT * FROM users WHERE username = :username", ['username' => $username]);
        return $result !== false ? $result : null;
    }

    public function findByEmail(string $email): ?array
    {
        $result = $this->db->fetch("SELECT * FROM users WHERE email = :email", ['email' => $email]);
        return $result !== false ? $result : null;
    }
}
