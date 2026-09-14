<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/checkout.css') ?>">
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
        </div>
    </header>

    <main class="checkout-page" style="flex:1; padding: 4rem 5%; max-width: 1200px; margin: 0 auto; width:100%;">
        <div style="margin-bottom: 2rem;">
            <h1 style="color:#0f172a; font-size:2.2rem; font-weight:800; letter-spacing:-0.5px;">Checkout</h1>
        </div>

        <?php if ($allErrors = errors()): ?>
            <div class="alert-error" role="alert">
                <strong style="display:block; margin-bottom:0.5rem;">Please review your checkout details:</strong>
                <ul style="margin-left: 1.5rem;">
                    <?php foreach ($allErrors as $error): ?>
                        <li><?= e((string) $error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($checkout['items'])): ?>
            <div class="form-card" style="margin: 0; max-width: 100%; text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;">🛒</div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color:#0f172a;">Your cart is empty</h2>
                <p style="color: #64748b; margin-bottom: 2rem;">Add at least one product before checking out.</p>
                <a class="btn-primary" href="<?= url('/products') ?>" style="display:inline-block; width:auto;">Browse Products</a>
            </div>
        <?php else: ?>
            <form action="<?= url('/checkout/confirm') ?>" method="POST" style="display:grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items:start;">
                <?= csrf_field() ?>
                <input type="hidden" name="return_to" value="<?= e($returnUrl) ?>">

                <div style="display:flex; flex-direction:column; gap:2rem;">
                    
                    <!-- Shipping Section -->
                    <section style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                        <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:1.5rem; border-bottom:1px solid #f1f5f9; padding-bottom:1rem;">Shipping Address</h2>
                        
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
                            <div class="form-group" style="margin:0;">
                                <label>Full name</label>
                                <input type="text" name="shipping_name" class="form-input" maxlength="150" required autocomplete="name" value="<?= old('shipping_name', $user['username'] ?? '') ?>">
                            </div>
                            <div class="form-group" style="margin:0;">
                                <label>Phone</label>
                                <input type="tel" name="shipping_phone" class="form-input" maxlength="30" required autocomplete="tel" value="<?= old('shipping_phone', $user['phone'] ?? '') ?>">
                            </div>
                            
                            <div class="form-group" style="margin:0; grid-column: 1 / -1;">
                                <label>Address line 1</label>
                                <input type="text" name="shipping_line1" class="form-input" maxlength="255" required autocomplete="address-line1" value="<?= old('shipping_line1') ?>">
                            </div>
                            
                            <div class="form-group" style="margin:0; grid-column: 1 / -1;">
                                <label>Address line 2 <span style="color:#94a3b8; font-weight:400;">(optional)</span></label>
                                <input type="text" name="shipping_line2" class="form-input" maxlength="255" autocomplete="address-line2" value="<?= old('shipping_line2') ?>">
                            </div>

                            <div class="form-group" style="margin:0;">
                                <label>City</label>
                                <input type="text" name="shipping_city" class="form-input" maxlength="100" required autocomplete="address-level2" value="<?= old('shipping_city') ?>">
                            </div>
                            
                            <div class="form-group" style="margin:0;">
                                <label>State / Province</label>
                                <input type="text" name="shipping_state" class="form-input" maxlength="100" required autocomplete="address-level1" value="<?= old('shipping_state') ?>">
                            </div>

                            <div class="form-group" style="margin:0;">
                                <label>Postal code</label>
                                <input type="text" name="shipping_postal_code" class="form-input" maxlength="20" required autocomplete="postal-code" value="<?= old('shipping_postal_code') ?>">
                            </div>
                            
                            <div class="form-group" style="margin:0;">
                                <label>Country</label>
                                <input type="text" name="shipping_country" class="form-input" maxlength="100" required autocomplete="country-name" value="<?= old('shipping_country', 'Philippines') ?>">
                            </div>
                        </div>
                    </section>

                    <!-- Cart Items Section -->
                    <section style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                        <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:1.5rem; border-bottom:1px solid #f1f5f9; padding-bottom:1rem;">Order Items</h2>
                        <div style="display:flex; flex-direction:column; gap:1.5rem;">
                            <?php foreach ($checkout['items'] as $item): ?>
                                <article style="display:flex; gap:1rem; align-items:center;">
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= e(url($item['image_url'])) ?>" alt="<?= e($item['name']) ?>" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;">
                                    <?php else: ?>
                                        <div style="width:80px; height:80px; background:#f1f5f9; border-radius:8px; border:1px solid #e2e8f0;"></div>
                                    <?php endif; ?>
                                    <div style="flex:1;">
                                        <h3 style="font-size:1.05rem; font-weight:600; color:#0f172a; margin-bottom:0.25rem;"><?= e($item['name']) ?></h3>
                                        <p style="color:#64748b; font-size:0.85rem; margin:0; margin-bottom:0.25rem;">SKU: <?= e($item['sku']) ?></p>
                                        <p style="color:#475569; font-weight:500; font-size:0.95rem; margin:0;"><?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                                    </div>
                                    <strong style="font-size:1.1rem; color:#0f172a; font-weight:800;">₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>

                </div>

                <!-- Summary Sidebar -->
                <aside style="position:sticky; top:100px;">
                    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:2rem; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05);">
                        <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:1.5rem;">Order Summary</h2>
                        <dl style="display:flex; flex-direction:column; gap:1rem; margin:0; color:#475569; font-size:0.95rem;">
                            <div style="display:flex; justify-content:space-between;"><dt>Subtotal</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $checkout['totals']['subtotal'], 2) ?></dd></div>
                            <div style="display:flex; justify-content:space-between;"><dt>Shipping</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $checkout['totals']['shipping_total'], 2) ?></dd></div>
                            <div style="display:flex; justify-content:space-between;"><dt>Tax</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $checkout['totals']['tax_total'], 2) ?></dd></div>
                            
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1rem; padding-top:1rem; border-top:1px solid #e2e8f0;">
                                <dt style="font-weight:800; color:#0f172a; font-size:1.1rem;">Grand Total</dt>
                                <dd style="font-weight:800; color:#f97316; font-size:1.5rem; margin:0;">₱<?= number_format((float) $checkout['totals']['grand_total'], 2) ?></dd>
                            </div>
                        </dl>
                        
                        <button type="submit" class="btn-primary" style="width:100%; margin-top:2rem; padding:1rem; font-size:1.05rem;">Confirm Order</button>
                        <a href="<?= e($cancelUrl) ?>" style="display:block; text-align:center; color:#64748b; font-weight:600; font-size:0.9rem; margin-top:1rem; text-decoration:none;">Cancel Checkout</a>
                        
                        <p style="font-size:0.8rem; color:#94a3b8; text-align:center; margin-top:1.5rem; line-height:1.4;">Stock and prices will be verified again upon confirmation.</p>
                    </div>
                </aside>
            </form>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
