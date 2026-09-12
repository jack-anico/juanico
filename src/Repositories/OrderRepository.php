<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

class OrderRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function database(): Database
    {
        return $this->db;
    }

    public function findActiveCartForUpdate(int $userId): ?array
    {
        $result = $this->db->fetch(
            "SELECT * FROM carts
             WHERE user_id = :user_id AND status = 'active'
             ORDER BY updated_at DESC, cart_id DESC
             LIMIT 1 FOR UPDATE",
            ['user_id' => $userId]
        );

        return $result !== false ? $result : null;
    }

    public function getCheckoutItems(int $cartId, bool $lock = false): array
    {
        $sql = "SELECT
                    ci.cart_item_id,
                    ci.product_id,
                    ci.quantity,
                    p.sku,
                    p.name,
                    p.price AS unit_price,
                    p.stock_quantity,
                    p.is_active,
                    p.deleted_at,
                    (SELECT url FROM product_images pi
                     WHERE pi.product_id = p.product_id
                     ORDER BY pi.sort_order ASC, pi.product_image_id ASC LIMIT 1) AS image_url
                FROM cart_items ci
                JOIN products p ON p.product_id = ci.product_id
                WHERE ci.cart_id = :cart_id
                ORDER BY ci.cart_item_id ASC";

        if ($lock) {
            $sql .= ' FOR UPDATE';
        }

        return $this->db->fetchAll($sql, ['cart_id' => $cartId]);
    }

    public function createOrder(int $userId, string $orderNumber, array $totals, array $shipping): int
    {
        $this->db->execute(
            "INSERT INTO orders (
                user_id, order_number, status, subtotal, shipping_total, tax_total, grand_total,
                shipping_name, shipping_phone, shipping_line1, shipping_line2, shipping_city,
                shipping_state, shipping_postal_code, shipping_country
             ) VALUES (
                :user_id, :order_number, 'confirmed', :subtotal, :shipping_total, :tax_total, :grand_total,
                :shipping_name, :shipping_phone, :shipping_line1, :shipping_line2, :shipping_city,
                :shipping_state, :shipping_postal_code, :shipping_country
             )",
            [
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'subtotal' => $totals['subtotal'],
                'shipping_total' => $totals['shipping_total'],
                'tax_total' => $totals['tax_total'],
                'grand_total' => $totals['grand_total'],
                'shipping_name' => $shipping['shipping_name'],
                'shipping_phone' => $shipping['shipping_phone'],
                'shipping_line1' => $shipping['shipping_line1'],
                'shipping_line2' => $shipping['shipping_line2'] ?: null,
                'shipping_city' => $shipping['shipping_city'],
                'shipping_state' => $shipping['shipping_state'],
                'shipping_postal_code' => $shipping['shipping_postal_code'],
                'shipping_country' => $shipping['shipping_country'],
            ]
        );

        return (int) $this->db->lastInsertId();
    }

    public function createOrderItem(int $orderId, array $item): void
    {
        $this->db->execute(
            "INSERT INTO order_items (
                order_id, product_id, product_name, product_sku, unit_price, quantity, line_total
             ) VALUES (
                :order_id, :product_id, :product_name, :product_sku, :unit_price, :quantity, :line_total
             )",
            [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'product_sku' => $item['sku'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'line_total' => $item['line_total'],
            ]
        );
    }

    public function decrementStock(int $productId, int $quantity): bool
    {
        return $this->db->execute(
            "UPDATE products
             SET stock_quantity = stock_quantity - :quantity
             WHERE product_id = :product_id
               AND stock_quantity >= :minimum_quantity
               AND is_active = 1
               AND deleted_at IS NULL",
            [
                'quantity' => $quantity,
                'minimum_quantity' => $quantity,
                'product_id' => $productId,
            ]
        ) === 1;
    }

    public function convertCart(int $cartId): void
    {
        $this->db->execute(
            "UPDATE carts SET status = 'converted' WHERE cart_id = :cart_id AND status = 'active'",
            ['cart_id' => $cartId]
        );
    }

    public function findForUserByNumber(int $userId, string $orderNumber): ?array
    {
        $result = $this->db->fetch(
            'SELECT * FROM orders WHERE user_id = :user_id AND order_number = :order_number LIMIT 1',
            ['user_id' => $userId, 'order_number' => $orderNumber]
        );

        return $result !== false ? $result : null;
    }

    public function findAllForUser(int $userId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM orders WHERE user_id = :user_id ORDER BY placed_at DESC, order_id DESC',
            ['user_id' => $userId]
        );
    }

    public function getOrderItems(int $orderId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM order_items WHERE order_id = :order_id ORDER BY order_item_id ASC',
            ['order_id' => $orderId]
        );
    }
}
