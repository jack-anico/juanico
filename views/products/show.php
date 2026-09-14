<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($product['name'] ?? 'Product not found') ?> - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh;">
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
                                    <nav class="main-nav">
                <ul>
                    <li><a href="<?= url('/#home') ?>">HOME</a></li>
                    <li><a href="<?= url('/products') ?>">PRODUCTS</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
            <div class="header-action" style="display:flex; gap:10px; align-items:center;">
                <?php if (isAuthenticated()): ?>
                    <form action="<?= url('/logout') ?>" method="POST" style="margin:0;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-shop" style="border:none; cursor:pointer;">LOGOUT</button>
                    </form>
                <?php endif; ?>
                <a href="#cart" id="open-cart-btn" class="btn-shop">CART (<span id="cart-count">0</span>)</a>
            </div>
        </div>
    </header>

    <main class="product-page" style="flex:1; padding: 3rem 5%; max-width: 1200px; margin: 0 auto; width:100%;">
        <div style="margin-bottom: 2rem;">
            <a href="<?= url('/products') ?>" style="color:#ff6b00; text-decoration:none; font-weight:600;">&larr; Back to Products</a>
        </div>

        <?php if (!$product): ?>
            <h1>Product not found</h1>
            <p>This product is no longer available. Browse our products to find something else.</p>
        <?php else: ?>
            <div class="product-page-layout">
                <div class="product-page-images">
                    <?php if (empty($product['images'])): ?>
                        <div class="product-card-placeholder" style="height:400px; display:flex; align-items:center; justify-content:center; background:#eaeaea; color:#999; border-radius:6px;">No image available.</div>
                    <?php else: ?>
                        <?php foreach ($product['images'] as $image): ?>
                            <img src="<?= e(url($image['url'])) ?>" alt="<?= e($product['name']) ?>" style="border-radius:6px; border:1px solid #e5e5e5; max-height:500px; width:100%; object-fit:cover;">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="product-page-details">
                    <?php if (!empty($product['category_name'])): ?>
                        <span class="badge" style="background:#1a252c; color:#fff; padding:0.3rem 0.6rem; border-radius:4px; font-size:0.75rem; font-weight:700; display:inline-block; margin-bottom:1rem;"><?= e(strtoupper($product['category_name'])) ?></span>
                    <?php endif; ?>
                    <h1 style="color:#1a252c; font-size:2.5rem; margin-bottom:1rem;"><?= e($product['name']) ?></h1>
                    
                    <p class="product-page-price" style="font-size:2rem; color:#1a252c; font-weight:800; margin-bottom:1.5rem;">₱<?= e(number_format((float) $product['price'], 2)) ?></p>
                    
                    <div style="background:#fff; border:1px solid #e5e5e5; padding:1.5rem; border-radius:6px; margin-bottom:1.5rem;">
                        <h4 style="margin-bottom:0.5rem; color:#1a252c;">Description</h4>
                        <p class="pd-description" style="color:#555; margin:0;"><?= e($product['description'] ?: 'No description available.') ?></p>
                    </div>
                    
                    <div style="display:flex; gap:2rem; margin-bottom:1.5rem; color:#666; font-size:0.9rem;">
                        <p><strong>SKU:</strong> <?= e($product['sku']) ?></p>
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <p class="status-active"><strong>Stock:</strong> In Stock (<?= (int) $product['stock_quantity'] ?>)</p>
                        <?php else: ?>
                            <p class="status-inactive"><strong>Stock:</strong> Out of Stock</p>
                        <?php endif; ?>
                    </div>

                    <form id="product-add-form" data-id="<?= (int) $product['product_id'] ?>" style="background:#f9f9f9; padding:1.5rem; border-radius:6px; border:1px solid #e5e5e5;">
                        <div class="pd-quantity-controls" style="margin-top:0;">
                            <label for="product-quantity" style="font-weight:600; color:#1a252c;">Quantity:</label>
                            <input type="number" id="product-quantity" name="quantity" class="form-input pd-qty-input" value="1" min="1" max="<?= (int) $product['stock_quantity'] ?>" step="1" required inputmode="numeric" style="width:80px;">
                        </div>
                        <button type="submit" class="btn-primary product-add-btn" style="width:100%; border:none; cursor:pointer;" <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- Basic Footer -->
    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>

    <?php
    $cartProducts = $product ? [$product] : [];
    require __DIR__ . '/_cart.php';
    ?>
</body>
</html>
