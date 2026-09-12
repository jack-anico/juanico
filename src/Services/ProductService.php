<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Exceptions\ValidationException;

/**
 * ProductService — Business logic for products.
 */
class ProductService
{
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
    }

    /**
     * Get all active products for the public view.
     */
    public function getAllActive(): array
    {
        $products = $this->productRepo->findAll();
        // Filter out inactive ones
        $active = array_filter($products, fn($p) => $p['is_active'] == 1);
        
        // Attach images
        foreach ($active as &$product) {
            $product['images'] = $this->productRepo->getImages((int)$product['product_id']);
        }
        
        return $active;
    }

    /**
     * Get all products for the admin view.
     */
    public function getAllForAdmin(): array
    {
        $products = $this->productRepo->findAll();
        foreach ($products as &$product) {
            $product['images'] = $this->productRepo->getImages((int)$product['product_id']);
        }
        return $products;
    }

    public function getById(int $id): ?array
    {
        $product = $this->productRepo->findById($id);
        if ($product) {
            $product['images'] = $this->productRepo->getImages($id);
        }
        return $product;
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data, ?array $imageFile): int
    {
        $this->validateProductData($data);

        // Simple slug generation
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $data['slug'] = $slug;

        $productId = $this->productRepo->create($data);

        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $this->handleImageUpload($productId, $imageFile);
        }

        return $productId;
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(int $id, array $data, ?array $imageFile): void
    {
        $product = $this->productRepo->findById($id);
        if (!$product) {
            throw new \Exception("Product not found");
        }

        $this->validateProductData($data);

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $data['slug'] = $slug;

        $this->productRepo->update($id, $data);

        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $this->handleImageUpload($id, $imageFile);
        }
    }

    /**
     * Delete a product if it has no orders.
     */
    public function deleteProduct(int $id): void
    {
        $product = $this->productRepo->findById($id);
        if (!$product) {
            throw new \Exception("Product not found");
        }

        if ($this->productRepo->hasOrders($id)) {
            throw new ValidationException(['general' => 'Cannot delete product because it has associated orders.']);
        }

        $this->productRepo->delete($id);
    }

    // -----------------------------------------------------------------
    //  Internal Helpers
    // -----------------------------------------------------------------

    private function validateProductData(array $data): void
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required.';
        }
        if (empty($data['sku'])) {
            $errors['sku'] = 'SKU is required.';
        }
        if (!isset($data['price']) || !is_numeric($data['price']) || (float)$data['price'] < 0) {
            $errors['price'] = 'Valid positive price is required.';
        }
        if (!isset($data['stock_quantity']) || !is_numeric($data['stock_quantity']) || (int)$data['stock_quantity'] < 0) {
            $errors['stock_quantity'] = 'Valid positive stock quantity is required.';
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }

    private function handleImageUpload(int $productId, array $file): void
    {
        $uploadDir = BASE_PATH . '/public/uploads/products/';
        
        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        // Basic security check on extension
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array(strtolower($extension), $allowed)) {
            throw new ValidationException(['image' => 'Invalid image format. Allowed: JPG, PNG, WEBP, GIF.']);
        }

        $filename = uniqid('prod_') . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $url = '/uploads/products/' . $filename;
            $this->productRepo->addImage($productId, $url);
        } else {
            throw new ValidationException(['image' => 'Failed to upload image.']);
        }
    }
}
