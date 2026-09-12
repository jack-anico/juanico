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
}
