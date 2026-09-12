<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

/**
 * ProductRepository — Handles database operations for the products and product_images tables.
 */
class ProductRepository implements RepositoryInterface
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findById(int $id): ?array
    {
        $result = $this->db->fetch("SELECT * FROM products WHERE product_id = :id AND deleted_at IS NULL", ['id' => $id]);
        return $result !== false ? $result : null;
    }

    public function findAll(): array
    {
        return $this->db->fetchAll("SELECT * FROM products WHERE deleted_at IS NULL ORDER BY created_at DESC");
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO products (sku, name, slug, description, price, stock_quantity, is_active) 
                VALUES (:sku, :name, :slug, :description, :price, :stock_quantity, :is_active)";
        
        $this->db->execute($sql, [
            'sku' => $data['sku'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
            'is_active' => $data['is_active'] ?? 1
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE products 
                SET sku = :sku, name = :name, slug = :slug, description = :description, 
                    price = :price, stock_quantity = :stock_quantity, is_active = :is_active 
                WHERE product_id = :id";
        
        $this->db->execute($sql, [
            'id' => $id,
            'sku' => $data['sku'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
            'is_active' => $data['is_active'] ?? 1
        ]);

        return true;
    }

    /**
     * Delete a product by ID. Uses hard delete for this implementation unless we enforce soft deletes strictly.
     * The schema has deleted_at, let's use soft delete.
     */
    public function delete(int $id): bool
    {
        $this->db->execute("UPDATE products SET deleted_at = CURRENT_TIMESTAMP WHERE product_id = :id", ['id' => $id]);
        return true;
    }

    // -----------------------------------------------------------------
    //  Domain-Specific Methods
    // -----------------------------------------------------------------

    /**
     * Check if a product has any associated order items.
     */
    public function hasOrders(int $productId): bool
    {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM order_items WHERE product_id = :id", ['id' => $productId]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Add an image for a product.
     */
    public function addImage(int $productId, string $url): void
    {
        $sql = "INSERT INTO product_images (product_id, url) VALUES (:product_id, :url)";
        $this->db->execute($sql, ['product_id' => $productId, 'url' => $url]);
    }

    /**
     * Get all images for a product.
     */
    public function getImages(int $productId): array
    {
        return $this->db->fetchAll("SELECT * FROM product_images WHERE product_id = :id ORDER BY sort_order ASC", ['id' => $productId]);
    }
}
