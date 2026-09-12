<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\CartService;
use App\Exceptions\ValidationException;

/**
 * CartController — API endpoints for the front-end cart interactions.
 */
class CartController extends BaseController
{
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
    }

    /**
     * GET /cart/api
     */
    public function getCart(): void
    {
        $data = $this->cartService->getCartData();
        $this->response->json(['success' => true, 'cart' => $data]);
    }

    /**
     * POST /cart/add
     */
    public function add(): void
    {
        // Simple JSON decoding from raw input, or use standard POST
        // Since we are using fetch API, we will read JSON payload.
        $json = file_get_contents('php://input');
        $payload = json_decode($json, true);

        $productId = (int) ($payload['product_id'] ?? 0);
        $quantity = (int) ($payload['quantity'] ?? 1);

        if (!$productId) {
            $this->response->json(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        try {
            $this->cartService->addItem($productId, $quantity);
            $cartData = $this->cartService->getCartData();
            $this->response->json(['success' => true, 'cart' => $cartData]);
        } catch (ValidationException $e) {
            $this->response->json(['success' => false, 'message' => implode(' ', $e->getErrors())], 400);
        } catch (\Exception $e) {
            $this->response->json(['success' => false, 'message' => 'Failed to add item.'], 500);
        }
    }

    /**
     * POST /cart/update
     */
    public function update(): void
    {
        $json = file_get_contents('php://input');
        $payload = json_decode($json, true);

        $productId = (int) ($payload['product_id'] ?? 0);
        $quantity = (int) ($payload['quantity'] ?? 0);

        if (!$productId) {
            $this->response->json(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        try {
            $this->cartService->updateQuantity($productId, $quantity);
            $cartData = $this->cartService->getCartData();
            $this->response->json(['success' => true, 'cart' => $cartData]);
        } catch (\Exception $e) {
            $this->response->json(['success' => false, 'message' => 'Failed to update item.'], 500);
        }
    }

    /**
     * POST /cart/remove
     */
    public function remove(): void
    {
        $json = file_get_contents('php://input');
        $payload = json_decode($json, true);

        $productId = (int) ($payload['product_id'] ?? 0);

        if (!$productId) {
            $this->response->json(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        try {
            $this->cartService->removeItem($productId);
            $cartData = $this->cartService->getCartData();
            $this->response->json(['success' => true, 'cart' => $cartData]);
        } catch (\Exception $e) {
            $this->response->json(['success' => false, 'message' => 'Failed to remove item.'], 500);
        }
    }
}
