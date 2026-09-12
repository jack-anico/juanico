<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProductService;

/**
 * ProductController — Public-facing product browsing.
 */
class ProductController extends BaseController
{
    private ProductService $productService;

    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
    }

    /**
     * GET /products — Display all active products for customers.
     */
    public function index(): void
    {
        $products = $this->productService->getAllActive();
        $this->response->view('products.index', ['products' => $products]);
    }

    /**
     * GET /products/{id} — Display one publicly available product.
     */
    public function show(string $id): void
    {
        $productId = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $product = $productId !== false ? $this->productService->getById($productId) : null;

        if (!$product || !$product['is_active']) {
            http_response_code(404);
            $product = null;
        }

        $this->response->view('products.show', ['product' => $product]);
    }
}
