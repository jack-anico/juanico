<?php
$pageTitle = 'Products – JUANICO';
$activeNav = 'products';
$extraCss  = [url('/assets/css/cart.css')];
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main">
    <div class="section-header" style="text-align:left; margin-bottom:2rem;">
        <span class="eyebrow">Our Catalog</span>
        <h1 style="font-size:2rem;">All Products</h1>
        <p>Browse our extensive collection of high-quality construction materials.</p>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <h2>No products available</h2>
            <p>Check back soon — new inventory is added regularly.</p>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['category_name'])): ?>
                        <span class="badge badge-pill" style="position:absolute;top:1rem;left:1rem;"><?= e($product['category_name']) ?></span>
                    <?php endif; ?>

                    <a href="<?= e(url('/products/' . (int) $product['product_id'])) ?>" style="text-decoration:none;display:flex;flex-direction:column;flex:1;">
                        <div class="product-img-wrap">
                            <?php if (!empty($product['images'])): ?>
                                <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>">
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:0.85rem;">No image</span>
                            <?php endif; ?>
                        </div>
                        <h4><?= e($product['name']) ?></h4>
                        <div class="price-row">
                            <span class="price">₱<?= number_format((float) $product['price'], 2) ?></span>
                            <span class="view-link">Details →</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.8rem;">
                            <span style="color:#94a3b8;">SKU: <?= e($product['sku']) ?></span>
                            <?php if ($product['stock_quantity'] > 0): ?>
                                <span class="stock-label in-stock">In Stock (<?= (int) $product['stock_quantity'] ?>)</span>
                            <?php else: ?>
                                <span class="stock-label out-stock">Out of Stock</span>
                            <?php endif; ?>
                        </div>
                    </a>

                    <button type="button"
                            class="btn-primary add-to-cart-btn mt-2"
                            data-id="<?= (int) $product['product_id'] ?>"
                            style="width:100%;"
                            <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php
$cartProducts = $products;
require VIEW_PATH . '/products/_cart.php';
require VIEW_PATH . '/partials/footer.php';
?>
