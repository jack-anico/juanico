<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\CheckoutService;

class OrderController extends BaseController
{
    private CheckoutService $checkoutService;

    public function __construct()
    {
        parent::__construct();
        $this->checkoutService = new CheckoutService();
    }

    public function index(): void
    {
        $orders = $this->checkoutService->getOrderHistory((int) authUserId());
        $this->response->view('orders.index', ['orders' => $orders]);
    }

    public function show(string $orderNumber): void
    {
        $order = $this->checkoutService->getOrder((int) authUserId(), $orderNumber);
        if (!$order) {
            http_response_code(404);
        }

        $this->response->view('orders.show', [
            'order' => $order,
            'showSuccess' => (bool) ($_SESSION['_flash']['purchase_success'] ?? false),
        ]);
    }
}
