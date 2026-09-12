<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProductService;
use App\Exceptions\ValidationException;

/**
 * AdminProductController — Handles product management for administrators.
 */
class AdminProductController extends BaseController
{
    private ProductService $productService;

    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
    }

    /**
     * GET /admin/products
     */
    public function index(): void
    {
        $products = $this->productService->getAllForAdmin();
        $this->response->view('admin.products.index', ['products' => $products]);
    }

    /**
     * GET /admin/products/create
     */
    public function create(): void
    {
        $this->response->view('admin.products.create');
    }

    /**
     * POST /admin/products
     */
    public function store(): void
    {
        if (!$this->request->validateCsrf()) {
            $this->backWithErrors(['csrf' => 'Invalid security token.']);
        }

        $data = $this->request->only(['name', 'sku', 'description', 'price', 'stock_quantity', 'is_active']);
        $imageFile = $this->request->file('image');

        try {
            $this->productService->createProduct($data, $imageFile);
            $this->response->redirect(url('/admin/products'));
        } catch (ValidationException $e) {
            $this->backWithErrors($e->getErrors(), $data);
        } catch (\Exception $e) {
            $this->backWithErrors(['general' => $e->getMessage()], $data);
        }
    }

    /**
     * GET /admin/products/edit/{id}
     */
    public function edit(string $id): void
    {
        $productId = (int) $id;
        $product = $this->productService->getById($productId);

        if (!$product) {
            $this->response->redirect(url('/admin/products'));
            return;
        }

        $this->response->view('admin.products.edit', ['product' => $product]);
    }

    /**
     * POST /admin/products/update/{id}
     */
    public function update(string $id): void
    {
        if (!$this->request->validateCsrf()) {
            $this->backWithErrors(['csrf' => 'Invalid security token.']);
        }

        $productId = (int) $id;
        $data = $this->request->only(['name', 'sku', 'description', 'price', 'stock_quantity', 'is_active']);
        $imageFile = $this->request->file('image');

        try {
            $this->productService->updateProduct($productId, $data, $imageFile);
            $this->response->redirect(url('/admin/products'));
        } catch (ValidationException $e) {
            $this->backWithErrors($e->getErrors(), $data);
        } catch (\Exception $e) {
            $this->backWithErrors(['general' => $e->getMessage()], $data);
        }
    }

    /**
     * POST /admin/products/delete/{id}
     */
    public function delete(string $id): void
    {
        if (!$this->request->validateCsrf()) {
            $this->response->redirect(url('/admin/products'));
            return;
        }

        $productId = (int) $id;

        try {
            $this->productService->deleteProduct($productId);
        } catch (ValidationException $e) {
            flash('errors', $e->getErrors());
        } catch (\Exception $e) {
            flash('errors', ['general' => 'Failed to delete product.']);
        }

        $this->response->redirect(url('/admin/products'));
    }
}
