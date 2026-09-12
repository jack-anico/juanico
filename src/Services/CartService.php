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
    private function resolveCartId(bool $createIfMissing = true): ?int
    {
        $userId = isAuthenticated() ? authUserId() : null;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($userId) {
            $sessionToken = $_SESSION['cart_session_token'] ?? null;
            $cart = $sessionToken
                ? $this->cartRepo->adoptGuestCart($userId, $sessionToken)
                : $this->cartRepo->findActiveCart($userId, null);

            if ($sessionToken) {
                unset($_SESSION['cart_session_token']);
            }

            if (!$cart && $createIfMissing) {
                return $this->cartRepo->createCart($userId, null);
            }

            return $cart ? (int) $cart['cart_id'] : null;
        }

        if (empty($_SESSION['cart_session_token'])) {
            if (!$createIfMissing) {
                return null;
            }
            $_SESSION['cart_session_token'] = bin2hex(random_bytes(16));
        }
        $sessionToken = $_SESSION['cart_session_token'];

        $cart = $this->cartRepo->findActiveCart(null, $sessionToken);

        if (!$cart) {
            return $createIfMissing ? $this->cartRepo->createCart(null, $sessionToken) : null;
        }

        return (int) $cart['cart_id'];
    }

    /**
     * Get full cart details including items and totals.
     */
    public function getCartData(): array
    {
        $cartId = $this->resolveCartId();
        return $this->buildCartData($cartId);
    }

    /**
     * Read the active cart without creating an empty one.
     */
    public function getExistingCartData(): array
    {
        return $this->buildCartData($this->resolveCartId(false));
    }

    private function buildCartData(?int $cartId): array
    {
        $items = $cartId ? $this->cartRepo->getCartItems($cartId) : [];

        $subtotal = 0.0;
        foreach ($items as &$item) {
            $item['quantity'] = (int) $item['quantity'];
            $item['unit_price'] = (float) $item['unit_price'];
            $item['line_total'] = $item['quantity'] * $item['unit_price'];
            $subtotal += $item['line_total'];
        }

        return [
            'cart_id' => $cartId,
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
