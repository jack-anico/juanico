<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Exceptions\ValidationException;

/**
 * CartService — Business logic for the shopping cart.
 */
class CartService
{
    private CartRepository $cartRepo;
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->cartRepo = new CartRepository();
        $this->productRepo = new ProductRepository();
    }

    /**
     * Resolve the active cart ID for the current session/user.
     */
    private function resolveCartId(): int
    {
        $userId = isAuthenticated() ? authUserId() : null;
        
        // Handle guest session token
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['cart_session_token'])) {
            $_SESSION['cart_session_token'] = bin2hex(random_bytes(16));
        }
        $sessionToken = $_SESSION['cart_session_token'];

        $cart = $this->cartRepo->findActiveCart($userId, $userId ? null : $sessionToken);

        if (!$cart) {
            return $this->cartRepo->createCart($userId, $userId ? null : $sessionToken);
        }

        return (int) $cart['cart_id'];
    }

    /**
     * Get full cart details including items and totals.
     */
    public function getCartData(): array
    {
        $cartId = $this->resolveCartId();
        $items = $this->cartRepo->getCartItems($cartId);

        $subtotal = 0.0;
        foreach ($items as &$item) {
            $item['quantity'] = (int) $item['quantity'];
            $item['unit_price'] = (float) $item['unit_price'];
            $item['line_total'] = $item['quantity'] * $item['unit_price'];
            $subtotal += $item['line_total'];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'item_count' => array_sum(array_column($items, 'quantity'))
        ];
    }

    /**
     * Add an item to the cart.
     */
    public function addItem(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new ValidationException(['quantity' => 'Quantity must be at least 1.']);
        }

        $product = $this->productRepo->findById($productId);
        if (!$product) {
            throw new ValidationException(['general' => 'Product not found.']);
        }
        
        if (!$product['is_active']) {
            throw new ValidationException(['general' => 'Product is not available.']);
        }

        // We aren't doing strict stock enforcement yet, but we could check here:
        // if ($product['stock_quantity'] < $quantity) { throw ... }

        $cartId = $this->resolveCartId();
        $this->cartRepo->addItem($cartId, $productId, $quantity, (float) $product['price']);
    }

    /**
     * Update the quantity of an item in the cart.
     */
    public function updateQuantity(int $productId, int $quantity): void
    {
        $cartId = $this->resolveCartId();
        
        if ($quantity <= 0) {
            $this->cartRepo->removeItem($cartId, $productId);
        } else {
            // Re-validate product exists just in case
            $product = $this->productRepo->findById($productId);
            if ($product) {
                 $this->cartRepo->updateItemQuantity($cartId, $productId, $quantity);
            }
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(int $productId): void
    {
        $cartId = $this->resolveCartId();
        $this->cartRepo->removeItem($cartId, $productId);
    }
}
