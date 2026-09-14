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

    <section class="catalog-section" style="padding-top:3rem; flex:1;">
        <div class="section-header">
            <h3>ALL PRODUCTS</h3>
            <h2>Our Full Catalog</h2>
        </div>
        
        <?php if (empty($products)): ?>
            <p class="text-center">No products available at the moment.</p>
        <?php else: ?>
            <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" style="display:flex; flex-direction:column;">
                    <?php if (!empty($product['category_name'])): ?>
                        <div class="badge"><?= e(strtoupper($product['category_name'])) ?></div>
                    <?php endif; ?>
                    
                    <a href="<?= e(url('/products/' . (int) $product['product_id'])) ?>" style="text-decoration:none; flex:1; display:flex; flex-direction:column;">
                        <?php if (!empty($product['images'])): ?>
                            <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>" class="product-img" style="object-fit:cover; width:100%;">
                        <?php else: ?>
                            <div class="product-img" style="display:flex; align-items:center; justify-content:center; color:#999; width:100%;">No Image</div>
                        <?php endif; ?>
                        
                        <h4 style="flex:1;"><?= e($product['name']) ?></h4>
                        <div class="price-row">
                            <span class="price">₱<?= e(number_format((float) $product['price'], 2)) ?></span>
                            <span class="view-link">VIEW &rarr;</span>
                        </div>
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <p class="stock-info status-active">In Stock (<?= (int)$product['stock_quantity'] ?>)</p>
                        <?php else: ?>
                            <p class="stock-info status-inactive">Out of Stock</p>
                        <?php endif; ?>
                    </a>
                    
                    <button type="button" class="btn-primary add-to-cart-btn mt-1" data-id="<?= (int) $product['product_id'] ?>" style="width:100%; padding:0.6rem; border:none; cursor:pointer;" <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Basic Footer -->
    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>

    <?php
    $cartProducts = $products;
    require __DIR__ . '/_cart.php';
    ?>
</body>
</html>
