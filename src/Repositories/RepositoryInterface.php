<?php

declare(strict_types=1);

namespace App\Repositories;

/**
 * RepositoryInterface — Contract for all repository classes.
 *
 * Ensures consistent CRUD method signatures across all repositories.
 * Each repository may add domain-specific methods beyond these.
 */
interface RepositoryInterface
{
    /**
     * Find a single record by its primary key.
     *
     * @param  int        $id Primary key value
     * @return array|null     Row data or null if not found
     */
    public function findById(int $id): ?array;

    /**
     * Retrieve all records.
     *
     * @return array Array of rows
     */
    public function findAll(): array;

    /**
     * Insert a new record.
     *
     * @param  array $data Column => value pairs
     * @return int         The new record's auto-increment ID
     */
    public function create(array $data): int;

    /**
     * Update an existing record.
     *
     * @param  int   $id   Primary key value
     * @param  array $data Column => value pairs to update
     * @return bool        True if at least one row was affected
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a record by its primary key.
     *
     * @param  int  $id Primary key value
     * @return bool     True if at least one row was deleted
     */
    public function delete(int $id): bool;
}
