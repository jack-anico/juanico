<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body>
    <div class="products-header">
        <h1>Products</h1>
        <div>
            <a href="<?= url('/') ?>">Back to Home</a> | 
            <button id="open-cart-btn">Cart (<span id="cart-count">0</span>)</button>
        </div>
    </div>
    <hr>

    <?php if (empty($products)): ?>
        <p>No products available at the moment.</p>
    <?php else: ?>
        <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <a class="product-details-link" href="<?= e(url('/products/' . (int) $product['product_id'])) ?>" aria-label="<?= e('View details for ' . $product['name']) ?>">
                <?php if (!empty($product['images'])): ?>
                    <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>">
                <?php else: ?>
                    <span class="product-card-placeholder">No Image</span>
                <?php endif; ?>

                    <span class="product-card-name"><?= e($product['name']) ?></span>
                    <span>Price: ₱<?= e(number_format((float) $product['price'], 2)) ?></span>
                    <span class="product-details-hint">View details</span>
                </a>
                <button type="button" class="add-to-cart-btn" data-id="<?= (int) $product['product_id'] ?>">Add to Cart</button>
            </article>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php
    $cartProducts = $products;
    require __DIR__ . '/_cart.php';
    ?>
</body>
</html>
