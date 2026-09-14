<?php
$pageTitle = e($product['name'] ?? 'Product Not Found') . ' – JUANICO';
$activeNav = 'products';
$extraCss  = [url('/assets/css/cart.css')];
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main">
    <nav style="margin-bottom:2rem;font-size:0.85rem;color:var(--color-text-muted);">
        <a href="<?= url('/products') ?>" style="color:var(--color-text-muted);text-decoration:none;">&larr; Back to Products</a>
    </nav>

    <?php if (!$product): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <h1 style="font-size:1.5rem;">Product not found</h1>
            <p>This product may have been removed or is no longer available.</p>
            <a href="<?= url('/products') ?>" class="btn-primary" style="display:inline-block;margin-top:1rem;">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="product-detail-grid">

            <!-- Gallery -->
            <div class="product-detail-gallery">
                <?php if (!empty($product['images'])): ?>
                    <?php foreach ($product['images'] as $image): ?>
                        <img src="<?= e(url($image['url'])) ?>" alt="<?= e($product['name']) ?>">
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-image">No image available</div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="product-detail-info">
                <?php if (!empty($product['category_name'])): ?>
                    <div class="category-badge">
                        <span class="badge badge-info"><?= e($product['category_name']) ?></span>
                    </div>
                <?php endif; ?>

                <h1><?= e($product['name']) ?></h1>
                <div class="product-detail-price">₱<?= number_format((float) $product['price'], 2) ?></div>

                <div class="product-meta">
                    <div class="product-meta-item">
                        <strong>SKU</strong>
                        <span><?= e($product['sku']) ?></span>
                    </div>
                    <div class="product-meta-item">
                        <strong>Availability</strong>
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <span class="status-active">In Stock (<?= (int) $product['stock_quantity'] ?>)</span>
                        <?php else: ?>
                            <span class="status-inactive">Out of Stock</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-description">
                    <h4>Description</h4>
                    <p><?= e($product['description'] ?: 'No description available.') ?></p>
                </div>

                <form id="product-add-form" data-id="<?= (int) $product['product_id'] ?>" class="add-to-cart-form">
                    <div class="qty-row">
                        <label for="product-quantity">Quantity</label>
                        <input type="number" id="product-quantity" name="quantity" class="qty-input"
                               value="1" min="1" max="<?= (int) $product['stock_quantity'] ?>" step="1" required inputmode="numeric">
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;padding:0.9rem;font-size:1rem;"
                        <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>
                        Add to Cart
                    </button>
                </form>

                <div id="cart-feedback" role="status" aria-live="polite" style="margin-top:0.75rem;"></div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
$cartProducts = $product ? [$product] : [];
require VIEW_PATH . '/products/_cart.php';
require VIEW_PATH . '/partials/footer.php';
?>
