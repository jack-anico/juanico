<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/checkout.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh;">
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
                        <nav class="main-nav">
                <ul>
                    <li><a href="<?= url('/#home') ?>">HOME</a></li>
                    <li><a href="<?= url('/products') ?>">PRODUCTS</a></li>
                    <li><a href="<?= url('/#services') ?>">SERVICES</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#projects') ?>">PROJECTS</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="checkout-page" style="flex:1;">
        <h1 style="margin-bottom: 2rem; color: #1a252c;">Your Shopping Cart</h1>

        <!-- Static Placeholder HTML for Full Cart Page -->
        <!-- The backend will need to iterate over session cart items here -->
        <div class="checkout-layout">
            <div>
                <section class="checkout-panel">
                    <h2>Cart Items</h2>
                    
                    <!-- Example Line Item -->
                    <article class="checkout-item">
                        <img src="<?= url('/assets/images/placeholder.jpg') ?>" alt="Product Name" style="border-radius:4px; border:1px solid #ddd;">
                        <div>
                            <h3 style="color:#1a252c;">Steel Rebar Bundle</h3>
                            <p>SKU: REBAR-001</p>
                            
                            <form action="<?= url('/cart/update') ?>" method="POST" style="margin-top:0.5rem; display:flex; align-items:center; gap:0.5rem;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="1">
                                <input type="number" name="quantity" value="2" min="1" class="form-input" style="width:70px; padding:0.4rem;">
                                <button type="submit" class="btn-secondary" style="padding:0.4rem 0.8rem; font-size:0.8rem;">Update</button>
                            </form>
                        </div>
                        <div style="text-align:right;">
                            <strong style="display:block; font-size:1.1rem; color:#1a252c;">₱179.98</strong>
                            <form action="<?= url('/cart/remove') ?>" method="POST" style="margin-top:0.5rem;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="1">
                                <button type="submit" style="background:none; border:none; color:#d93025; text-decoration:underline; cursor:pointer; font-size:0.85rem;">Remove</button>
                            </form>
                        </div>
                    </article>

                    <!-- Example Line Item 2 -->
                    <article class="checkout-item">
                        <img src="<?= url('/assets/images/placeholder.jpg') ?>" alt="Product Name" style="border-radius:4px; border:1px solid #ddd;">
                        <div>
                            <h3 style="color:#1a252c;">Professional Tool Kit</h3>
                            <p>SKU: TOOL-005</p>
                            
                            <form action="<?= url('/cart/update') ?>" method="POST" style="margin-top:0.5rem; display:flex; align-items:center; gap:0.5rem;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="2">
                                <input type="number" name="quantity" value="1" min="1" class="form-input" style="width:70px; padding:0.4rem;">
                                <button type="submit" class="btn-secondary" style="padding:0.4rem 0.8rem; font-size:0.8rem;">Update</button>
                            </form>
                        </div>
                        <div style="text-align:right;">
                            <strong style="display:block; font-size:1.1rem; color:#1a252c;">₱149.99</strong>
                            <form action="<?= url('/cart/remove') ?>" method="POST" style="margin-top:0.5rem;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="2">
                                <button type="submit" style="background:none; border:none; color:#d93025; text-decoration:underline; cursor:pointer; font-size:0.85rem;">Remove</button>
                            </form>
                        </div>
                    </article>

                </section>
            </div>

            <aside class="checkout-panel order-summary">
                <h2>Order Summary</h2>
                <dl>
                    <div><dt>Subtotal</dt><dd>₱329.97</dd></div>
                    <div><dt>Estimated Tax</dt><dd>₱0.00</dd></div>
                    <div class="summary-total"><dt>Total</dt><dd>₱329.97</dd></div>
                </dl>
                
                <a href="<?= url('/checkout') ?>" class="btn-primary" style="display:block; text-align:center; text-decoration:none; margin-top:1.5rem; padding:0.8rem;">Proceed to Checkout</a>
                <a href="<?= url('/products') ?>" class="btn-secondary" style="display:block; text-align:center; text-decoration:none; margin-top:0.8rem; padding:0.8rem; border:1px solid #ccc; color:#333;">Continue Shopping</a>
            </aside>
        </div>
    </main>

    <!-- Basic Footer -->
    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
