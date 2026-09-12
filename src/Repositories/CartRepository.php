<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

/**
 * CartRepository — Handles database operations for carts and cart_items.
 */
class CartRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find an active cart for the user or guest session token.
     */
    public function findActiveCart(?int $userId, ?string $sessionToken): ?array
    {
        $sql = "SELECT * FROM carts WHERE status = 'active'";
        $params = [];

        if ($userId) {
            $sql .= " AND user_id = :user_id";
            $params['user_id'] = $userId;
        } elseif ($sessionToken) {
            $sql .= " AND session_token = :session_token AND user_id IS NULL";
            $params['session_token'] = $sessionToken;
        } else {
            return null;
        }

        $sql .= " ORDER BY updated_at DESC, cart_id DESC LIMIT 1";

        $result = $this->db->fetch($sql, $params);
        return $result !== false ? $result : null;
    }

    /**
     * Create a new active cart.
     */
    public function createCart(?int $userId, ?string $sessionToken): int
    {
        $sql = "INSERT INTO carts (user_id, session_token) VALUES (:user_id, :session_token)";
        $this->db->execute($sql, [
            'user_id' => $userId,
            'session_token' => $sessionToken
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Get all items in a cart, joining with product details.
     */
    public function getCartItems(int $cartId): array
    {
        $sql = "
            SELECT 
                ci.cart_item_id, ci.cart_id, ci.product_id, ci.quantity, ci.unit_price,
                p.name, p.description, p.stock_quantity,
                (SELECT url FROM product_images WHERE product_images.product_id = p.product_id ORDER BY sort_order ASC LIMIT 1) as image_url
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.product_id
            WHERE ci.cart_id = :cart_id
        ";
        return $this->db->fetchAll($sql, ['cart_id' => $cartId]);
    }

    /**
     * Add or update an item in the cart.
     */
    public function addItem(int $cartId, int $productId, int $quantity, float $unitPrice): void
    {
        // Using ON DUPLICATE KEY UPDATE to handle both insert and update efficiently
        $sql = "
            INSERT INTO cart_items (cart_id, product_id, quantity, unit_price) 
            VALUES (:cart_id, :product_id, :quantity, :unit_price)
            ON DUPLICATE KEY UPDATE 
                quantity = quantity + :quantity2,
                unit_price = :unit_price2
        ";
        $this->db->execute($sql, [
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'quantity2' => $quantity,
            'unit_price2' => $unitPrice
        ]);
    }

    /**
     * Update exact quantity of a cart item.
     */
    public function updateItemQuantity(int $cartId, int $productId, int $quantity): void
    {
        $sql = "UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id";
        $this->db->execute($sql, [
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(int $cartId, int $productId): void
    {
        $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id";
        $this->db->execute($sql, [
            'cart_id' => $cartId,
            'product_id' => $productId
        ]);
    }

    /**
     * Move a guest cart into the signed-in account. If the account already has
     * an active cart, merge the guest quantities into it.
     */
    public function adoptGuestCart(int $userId, string $sessionToken): ?array
    {
        $guestCart = $this->findActiveCart(null, $sessionToken);
        $userCart = $this->findActiveCart($userId, null);

        if (!$guestCart) {
            return $userCart;
        }

        $this->db->beginTransaction();

        try {
            if (!$userCart) {
                $this->db->execute(
                    "UPDATE carts
                     SET user_id = :user_id, session_token = NULL
                     WHERE cart_id = :cart_id AND status = 'active'",
                    ['user_id' => $userId, 'cart_id' => $guestCart['cart_id']]
                );
            } else {
                $guestItems = $this->db->fetchAll(
                    'SELECT product_id, quantity, unit_price FROM cart_items WHERE cart_id = :cart_id',
                    ['cart_id' => $guestCart['cart_id']]
                );
                foreach ($guestItems as $item) {
                    $this->addItem(
                        (int) $userCart['cart_id'],
                        (int) $item['product_id'],
                        (int) $item['quantity'],
                        (float) $item['unit_price']
                    );
                }
                $this->db->execute(
                    "UPDATE carts SET status = 'abandoned' WHERE cart_id = :cart_id",
                    ['cart_id' => $guestCart['cart_id']]
                );
            }

            $this->db->commit();
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }

        return $this->findActiveCart($userId, null);
    }
}
