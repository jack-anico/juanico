<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Repositories\UserRepository;
use App\Services\CheckoutService;

class CheckoutController extends BaseController
{
    private CheckoutService $checkoutService;

    public function __construct()
    {
        parent::__construct();
        $this->checkoutService = new CheckoutService();
    }

    public function show(): void
    {
        $userId = (int) authUserId();
        $checkout = $this->checkoutService->getCheckoutData();
        $user = (new UserRepository())->findById($userId);
        $returnUrl = $this->returnUrl((string) $this->request->input('return_to', url('/products')));

        $this->response->view('checkout.index', [
            'checkout' => $checkout,
            'user' => $user,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $this->cancelUrl($returnUrl),
        ]);
    }

    public function confirm(): void
    {
        $fields = [
            'shipping_name',
            'shipping_phone',
            'shipping_line1',
            'shipping_line2',
            'shipping_city',
            'shipping_state',
            'shipping_postal_code',
            'shipping_country',
        ];
        $shipping = $this->request->only($fields);
        $returnUrl = $this->returnUrl((string) $this->request->input('return_to', url('/products')));

        if (!$this->request->validateCsrf()) {
            $this->redirectWithErrors(['csrf' => 'Your checkout session expired. Please try again.'], $shipping, $returnUrl);
        }

        try {
            $result = $this->checkoutService->confirmOrder((int) authUserId(), $shipping);
            flash('purchase_success', true);
            $this->response->redirect(url('/orders/' . rawurlencode($result['order_number'])));
        } catch (ValidationException $e) {
            $this->redirectWithErrors($e->getErrors(), $shipping, $returnUrl);
        } catch (\Throwable $e) {
            error_log('Checkout failed: ' . $e->getMessage());
            $this->redirectWithErrors(
                ['general' => 'We could not place your order. Your cart has not been changed. Please try again.'],
                $shipping,
                $returnUrl
            );
        }
    }

    private function redirectWithErrors(array $errors, array $old, string $returnUrl): never
    {
        flash('errors', $errors);
        flash('old', $old);
        $this->response->redirect(url('/checkout') . '?return_to=' . rawurlencode($returnUrl));
    }

    private function returnUrl(string $requestedUrl): string
    {
        $appBase = rtrim(url('/'), '/');
        $fallback = url('/products');

        if (!str_starts_with($requestedUrl, $appBase . '/')) {
            return $fallback;
        }

        return $requestedUrl;
    }

    private function cancelUrl(string $returnUrl): string
    {
        $separator = str_contains($returnUrl, '?') ? '&' : '?';
        return $returnUrl . $separator . 'cart=open';
    }
}
