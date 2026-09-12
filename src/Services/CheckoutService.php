<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\OrderRepository;

class CheckoutService
{
    private const SHIPPING_TOTAL = 0.00;
    private const TAX_TOTAL = 0.00;

    private CartService $cartService;
    private OrderRepository $orderRepo;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->orderRepo = new OrderRepository();
    }

    public function getCheckoutData(): array
    {
        $cart = $this->cartService->getExistingCartData();
        $items = $cart['cart_id']
            ? $this->orderRepo->getCheckoutItems((int) $cart['cart_id'])
            : [];

        return [
            'items' => $this->normalizeItems($items),
            'totals' => $this->calculateTotals($items),
        ];
    }

    public function confirmOrder(int $userId, array $shipping): array
    {
        $shipping = $this->validateShipping($shipping);
        $db = $this->orderRepo->database();
        $db->beginTransaction();

        try {
            $cart = $this->orderRepo->findActiveCartForUpdate($userId);
            if (!$cart) {
                throw new ValidationException(['cart' => 'Your cart is empty. Add a product before checking out.']);
            }

            $items = $this->orderRepo->getCheckoutItems((int) $cart['cart_id'], true);
            if (!$items) {
                throw new ValidationException(['cart' => 'Your cart is empty. Add a product before checking out.']);
            }

            $items = $this->normalizeItems($items);
            foreach ($items as $item) {
                if ($item['deleted_at'] !== null || !(bool) $item['is_active']) {
                    throw new ValidationException([
                        'stock' => sprintf('%s is no longer available. Remove it from your cart to continue.', $item['name']),
                    ]);
                }
                if ($item['quantity'] > $item['stock_quantity']) {
                    throw new ValidationException([
                        'stock' => sprintf(
                            '%s only has %d item(s) available, but your cart requests %d.',
                            $item['name'],
                            $item['stock_quantity'],
                            $item['quantity']
                        ),
                    ]);
                }
            }

            $totals = $this->calculateTotals($items);
            $orderNumber = $this->generateOrderNumber();
            $orderId = $this->orderRepo->createOrder($userId, $orderNumber, $totals, $shipping);

            foreach ($items as $item) {
                $this->orderRepo->createOrderItem($orderId, $item);
                if (!$this->orderRepo->decrementStock($item['product_id'], $item['quantity'])) {
                    throw new ValidationException([
                        'stock' => sprintf('%s no longer has enough stock. Your order was not placed.', $item['name']),
                    ]);
                }
            }

            $this->orderRepo->convertCart((int) $cart['cart_id']);
            $db->commit();

            return ['order_id' => $orderId, 'order_number' => $orderNumber];
        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }

    public function getOrderHistory(int $userId): array
    {
        $orders = $this->orderRepo->findAllForUser($userId);
        foreach ($orders as &$order) {
            $order['items'] = $this->orderRepo->getOrderItems((int) $order['order_id']);
        }
        unset($order);
        return $orders;
    }

    public function getOrder(int $userId, string $orderNumber): ?array
    {
        $order = $this->orderRepo->findForUserByNumber($userId, $orderNumber);
        if (!$order) {
            return null;
        }
        $order['items'] = $this->orderRepo->getOrderItems((int) $order['order_id']);
        return $order;
    }

    private function normalizeItems(array $items): array
    {
        foreach ($items as &$item) {
            $item['product_id'] = (int) $item['product_id'];
            $item['quantity'] = (int) $item['quantity'];
            $item['stock_quantity'] = (int) $item['stock_quantity'];
            $item['unit_price'] = (float) $item['unit_price'];
            $item['line_total'] = round($item['unit_price'] * $item['quantity'], 2);
        }
        unset($item);
        return $items;
    }

    private function calculateTotals(array $items): array
    {
        $subtotal = 0.00;
        foreach ($items as $item) {
            $subtotal += round((float) $item['unit_price'] * (int) $item['quantity'], 2);
        }
        $subtotal = round($subtotal, 2);
        $shipping = self::SHIPPING_TOTAL;
        $tax = self::TAX_TOTAL;

        return [
            'subtotal' => $subtotal,
            'shipping_total' => $shipping,
            'tax_total' => $tax,
            'grand_total' => round($subtotal + $shipping + $tax, 2),
        ];
    }

    private function validateShipping(array $shipping): array
    {
        $rules = [
            'shipping_name' => ['Shipping name', 150, true],
            'shipping_phone' => ['Phone', 30, true],
            'shipping_line1' => ['Address line 1', 255, true],
            'shipping_line2' => ['Address line 2', 255, false],
            'shipping_city' => ['City', 100, true],
            'shipping_state' => ['State or province', 100, true],
            'shipping_postal_code' => ['Postal code', 20, true],
            'shipping_country' => ['Country', 100, true],
        ];
        $errors = [];
        $clean = [];

        foreach ($rules as $field => [$label, $maxLength, $required]) {
            $value = trim((string) ($shipping[$field] ?? ''));
            $clean[$field] = $value;
            if ($required && $value === '') {
                $errors[$field] = $label . ' is required.';
            } elseif (strlen($value) > $maxLength) {
                $errors[$field] = sprintf('%s cannot exceed %d characters.', $label, $maxLength);
            }
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        return $clean;
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    }
}
