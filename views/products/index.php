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
                <button type="button" class="product-details-btn" data-id="<?= (int) $product['product_id'] ?>" aria-haspopup="dialog" aria-controls="cart-modal" aria-label="<?= e('View details for ' . $product['name']) ?>">
                <?php if (!empty($product['images'])): ?>
                    <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>">
                <?php else: ?>
                    <span class="product-card-placeholder">No Image</span>
                <?php endif; ?>

                    <span class="product-card-name"><?= e($product['name']) ?></span>
                    <span>Price: ₱<?= e(number_format((float) $product['price'], 2)) ?></span>
                    <span class="product-details-hint">View details</span>
                </button>
                <button type="button" class="add-to-cart-btn" data-id="<?= (int) $product['product_id'] ?>">Add to Cart</button>
            </article>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p id="cart-feedback" role="status" aria-live="polite"></p>

    <!-- Shared dialog for the cart and product previews. -->
    <dialog id="cart-modal" aria-labelledby="modal-heading">
        <div class="modal-header">
            <h2 id="modal-heading" tabindex="-1">Your Cart</h2>
            <button type="button" id="close-cart-btn" autofocus>Close</button>
        </div>
        <!-- View 1: Mini Cart -->
        <div id="mini-cart-view">
            <div id="cart-items-container">
                <!-- Items rendered here via JS -->
            </div>

            <div class="mini-cart-subtotal">
                <strong>Grand Subtotal: ₱<span id="cart-subtotal">0.00</span></strong>
            </div>
        </div>

        <!-- View 2: Product Detail Modal -->
        <div id="product-detail-view" hidden>
            <button type="button" id="back-to-cart-btn">← Back to cart</button>
            
            <div id="pd-content">
                <!-- Rendered via JS -->
            </div>
            
            <div class="pd-quantity-controls">
                <label for="pd-qty-input">Quantity:</label>
                <button type="button" id="pd-qty-minus" aria-label="Decrease quantity">−</button>
                <input type="number" id="pd-qty-input" class="pd-qty-input" value="1" min="1" step="1" required inputmode="numeric">
                <button type="button" id="pd-qty-plus" aria-label="Increase quantity">+</button>
            </div>

            <div class="pd-actions">
                <button type="button" id="pd-remove-btn" class="pd-remove-btn">Remove Item</button>
                <button type="button" id="pd-update-btn">Update Quantity</button>
            </div>
        </div>
        <p id="modal-feedback" role="status" aria-live="polite" hidden></p>
    </dialog>

    <?php
    $productPreviews = array_values(array_map(static fn(array $product): array => [
        'product_id' => (int) $product['product_id'],
        'name' => $product['name'],
        'description' => $product['description'],
        'sku' => $product['sku'],
        'price' => (float) $product['price'],
        'stock_quantity' => (int) $product['stock_quantity'],
        'images' => array_map(static fn(array $image): array => ['url' => $image['url']], $product['images']),
    ], $products));
    ?>
    <script type="application/json" id="product-data"><?= json_encode($productPreviews, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_INVALID_UTF8_SUBSTITUTE) ?></script>
    <script>
        window.baseUrl = <?= json_encode(rtrim(url(''), '/'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    </script>
    <script src="<?= url('/assets/js/cart.js') ?>"></script>
</body>
</html>
