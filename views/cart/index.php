<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh; background:#f8fafc;">
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
                <?php else: ?>
                    <a href="<?= url('/login') ?>" class="btn-shop" style="background:transparent; color:#0f172a; border:1px solid #e2e8f0;">LOGIN</a>
                <?php endif; ?>
                <a href="#cart" id="open-cart-btn" class="btn-shop">CART (<span id="cart-count">0</span>)</a>
            </div>
        </div>
    </header>

    <main style="flex:1; padding: 4rem 5%; max-width: 1000px; margin: 0 auto; width:100%;">
        <div style="margin-bottom: 2rem;">
            <h1 style="color:#0f172a; font-size:2.2rem; font-weight:800; letter-spacing:-0.5px;">Your Cart</h1>
        </div>

        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:4rem 2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); text-align:center;">
            <div style="font-size:3.5rem; color:#cbd5e1; margin-bottom:1.5rem;">🛒</div>
            <h2 style="font-size: 1.5rem; color:#0f172a; margin-bottom:1rem; font-weight:700;">Full cart page coming soon</h2>
            <p style="color:#64748b; margin-bottom:2rem; font-size:1.05rem;">You can currently view and manage your cart using the slide-out drawer on any product page.</p>
            <a href="<?= url('/products') ?>" class="btn-primary" style="display:inline-block; width:auto; padding:1rem 2rem;">Continue Shopping</a>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>
    
    <?php
    $cartProducts = []; 
    require __DIR__ . '/../products/_cart.php';
    ?>
</body>
</html>
