<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh;">
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
                        <button type="button" class="hamburger-btn" aria-label="Toggle navigation" onclick="document.querySelector('.main-nav').classList.toggle('nav-open')">&#9776;</button>
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

    <section class="catalog-section" style="flex:1;">
        <div class="section-header">
            <h3>ALL PRODUCTS</h3>
            <h2>Our Full Catalog</h2>
            <p>Browse our extensive collection of high-quality construction materials, expertly curated to meet all your project needs.</p>
        </div>
        
        <?php if (empty($products)): ?>
            <div class="form-card" style="margin: 0 auto; text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;">🔍</div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color:#0f172a;">No products available</h2>
                <p style="color: #64748b;">Check back soon for new inventory.</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" style="display:flex; flex-direction:column;">
                    <?php if (!empty($product['category_name'])): ?>
                        <div class="badge"><?= e(strtoupper($product['category_name'])) ?></div>
                    <?php endif; ?>
                    
                    <a href="<?= e(url('/products/' . (int) $product['product_id'])) ?>" style="text-decoration:none; flex:1; display:flex; flex-direction:column;">
                        <?php if (!empty($product['images'])): ?>
                            <div class="product-img">
                                <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>">
                            </div>
                        <?php else: ?>
                            <div class="product-img" style="color:#94a3b8; font-weight:500;">No Image</div>
                        <?php endif; ?>
                        
                        <h4 style="flex:1; font-size:1.1rem; line-height:1.4; margin-bottom:0.75rem;"><?= e($product['name']) ?></h4>
                        <div class="price-row">
                            <span class="price">₱<?= e(number_format((float) $product['price'], 2)) ?></span>
                            <span class="view-link">VIEW &rarr;</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.8rem; color:#64748b;">SKU: <?= e($product['sku']) ?></span>
                            <?php if ($product['stock_quantity'] > 0): ?>
                                <p class="stock-info status-active">In Stock (<?= (int)$product['stock_quantity'] ?>)</p>
                            <?php else: ?>
                                <p class="stock-info status-inactive">Out of Stock</p>
                            <?php endif; ?>
                        </div>
                    </a>
                    
                    <button type="button" class="btn-shop add-to-cart-btn mt-3" data-id="<?= (int) $product['product_id'] ?>" style="width:100%; padding:0.8rem; border:none; cursor:pointer;" <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Basic Footer -->
    <footer class="site-footer">
        <div class="footer-bottom">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>

    <?php
    $cartProducts = $products;
    require __DIR__ . '/_cart.php';
    ?>
</body>
</html>
