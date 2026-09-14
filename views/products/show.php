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

    <main class="product-page" style="flex:1; padding: 4rem 5%; max-width: 1200px; margin: 0 auto; width:100%;">
        <div style="margin-bottom: 2.5rem;">
            <a href="<?= url('/products') ?>" style="color:#64748b; text-decoration:none; font-weight:600; font-size:0.95rem; transition:color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#64748b'">&larr; Back to Products</a>
        </div>

        <?php if (!$product): ?>
            <div class="form-card" style="margin:0 auto; text-align:center;">
                <h1 style="color:#0f172a; font-size:2rem; font-weight:800; margin-bottom:1rem;">Product not found</h1>
                <p style="color:#64748b;">This product is no longer available. Browse our catalog to find something else.</p>
            </div>
        <?php else: ?>
            <div style="display:grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap:4rem; align-items:start;">
                
                <div class="product-page-images" style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                    <?php if (empty($product['images'])): ?>
                        <div style="height:400px; display:flex; align-items:center; justify-content:center; background:#f1f5f9; color:#94a3b8; border-radius:12px; font-weight:500;">No image available</div>
                    <?php else: ?>
                        <?php foreach ($product['images'] as $image): ?>
                            <img src="<?= e(url($image['url'])) ?>" alt="<?= e($product['name']) ?>" style="border-radius:8px; width:100%; max-height:500px; object-fit:contain;">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="product-page-details">
                    <?php if (!empty($product['category_name'])): ?>
                        <span class="badge" style="margin-bottom:1.5rem;"><?= e(strtoupper($product['category_name'])) ?></span>
                    <?php endif; ?>
                    
                    <h1 style="color:#0f172a; font-size:3rem; font-weight:800; letter-spacing:-1px; margin-bottom:1rem; line-height:1.2;"><?= e($product['name']) ?></h1>
                    
                    <p class="product-page-price" style="font-size:2.5rem; color:#0f172a; font-weight:800; margin-bottom:2rem;">₱<?= e(number_format((float) $product['price'], 2)) ?></p>
                    
                    <div style="display:flex; gap:2rem; margin-bottom:2rem; padding:1rem 0; border-top:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0; font-size:0.95rem;">
                        <p style="color:#475569;"><strong>SKU:</strong> <?= e($product['sku']) ?></p>
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <p class="status-active"><strong>Stock:</strong> In Stock (<?= (int) $product['stock_quantity'] ?>)</p>
                        <?php else: ?>
                            <p class="status-inactive"><strong>Stock:</strong> Out of Stock</p>
                        <?php endif; ?>
                    </div>
                    
                    <div style="margin-bottom:2.5rem;">
                        <h4 style="margin-bottom:0.75rem; color:#0f172a; font-size:1.1rem; font-weight:700;">Description</h4>
                        <p style="color:#475569; line-height:1.7;"><?= e($product['description'] ?: 'No description available.') ?></p>
                    </div>

                    <form id="product-add-form" data-id="<?= (int) $product['product_id'] ?>" style="background:#fff; padding:2rem; border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05);">
                        <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:1.5rem;">
                            <label for="product-quantity" style="font-weight:600; color:#0f172a;">Quantity:</label>
                            <input type="number" id="product-quantity" name="quantity" class="form-input" value="1" min="1" max="<?= (int) $product['stock_quantity'] ?>" step="1" required inputmode="numeric" style="width:100px; text-align:center; font-size:1.1rem;">
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%; padding:1.2rem; font-size:1.1rem;" <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>

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
