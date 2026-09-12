<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($product['name'] ?? 'Product not found') ?> - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body>
    <nav class="products-header" aria-label="Store navigation">
        <a href="<?= url('/products') ?>">← Back to Products</a>
        <?php if (isAuthenticated()): ?><a href="<?= url('/orders') ?>">Order History</a><?php endif; ?>
        <button type="button" id="open-cart-btn">Cart (<span id="cart-count">0</span>)</button>
    </nav>

    <main class="product-page">
        <?php if (!$product): ?>
            <h1>Product not found</h1>
            <p>This product is no longer available. Browse our products to find something else.</p>
        <?php else: ?>
            <div class="product-page-layout">
                <div class="product-page-images">
                    <?php if (empty($product['images'])): ?>
                        <div class="product-card-placeholder">No image available.</div>
                    <?php else: ?>
                        <?php foreach ($product['images'] as $image): ?>
                            <img src="<?= e(url($image['url'])) ?>" alt="<?= e($product['name']) ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="product-page-details">
                    <h1><?= e($product['name']) ?></h1>
                    <p class="product-page-price">₱<?= e(number_format((float) $product['price'], 2)) ?></p>
                    <p class="pd-description"><?= e($product['description'] ?: 'No description available.') ?></p>
                    <p>SKU: <?= e($product['sku']) ?></p>
                    <p>Stock available: <?= (int) $product['stock_quantity'] ?></p>

                    <form id="product-add-form" data-id="<?= (int) $product['product_id'] ?>">
                        <div class="pd-quantity-controls">
                            <label for="product-quantity">Quantity:</label>
                            <input type="number" id="product-quantity" name="quantity" class="pd-qty-input" value="1" min="1" step="1" required inputmode="numeric">
                        </div>
                        <button type="submit" class="product-add-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php
    $cartProducts = $product ? [$product] : [];
    require __DIR__ . '/_cart.php';
    ?>
</body>
</html>
