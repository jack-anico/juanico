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
<body>
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

    <main class="checkout-page">
        <h1>Checkout</h1>

        <?php if ($allErrors = errors()): ?>
            <div class="checkout-alert" role="alert">
                <strong>Please review your checkout details.</strong>
                <ul>
                    <?php foreach ($allErrors as $error): ?>
                        <li><?= e((string) $error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($checkout['items'])): ?>
            <section class="checkout-panel">
                <h2>Your cart is empty</h2>
                <p>Add at least one product before checking out.</p>
                <a class="checkout-primary-link" href="<?= url('/products') ?>">Browse Products</a>
            </section>
        <?php else: ?>
            <form action="<?= url('/checkout/confirm') ?>" method="POST" class="checkout-layout">
                <?= csrf_field() ?>
                <input type="hidden" name="return_to" value="<?= e($returnUrl) ?>">

                <div>
                    <section class="checkout-panel">
                        <h2>Shipping Address</h2>
                        <div class="shipping-fields">
                            <label>
                                Full name
                                <input type="text" name="shipping_name" maxlength="150" required autocomplete="name" value="<?= old('shipping_name', $user['username'] ?? '') ?>">
                            </label>
                            <label>
                                Phone
                                <input type="tel" name="shipping_phone" maxlength="30" required autocomplete="tel" value="<?= old('shipping_phone', $user['phone'] ?? '') ?>">
                            </label>
                            <label class="field-wide">
                                Address line 1
                                <input type="text" name="shipping_line1" maxlength="255" required autocomplete="address-line1" value="<?= old('shipping_line1') ?>">
                            </label>
                            <label class="field-wide">
                                Address line 2 <span>(optional)</span>
                                <input type="text" name="shipping_line2" maxlength="255" autocomplete="address-line2" value="<?= old('shipping_line2') ?>">
                            </label>
                            <label>
                                City
                                <input type="text" name="shipping_city" maxlength="100" required autocomplete="address-level2" value="<?= old('shipping_city') ?>">
                            </label>
                            <label>
                                State / Province
                                <input type="text" name="shipping_state" maxlength="100" required autocomplete="address-level1" value="<?= old('shipping_state') ?>">
                            </label>
                            <label>
                                Postal code
                                <input type="text" name="shipping_postal_code" maxlength="20" required autocomplete="postal-code" value="<?= old('shipping_postal_code') ?>">
                            </label>
                            <label>
                                Country
                                <input type="text" name="shipping_country" maxlength="100" required autocomplete="country-name" value="<?= old('shipping_country', 'Philippines') ?>">
                            </label>
                        </div>
                    </section>

                    <section class="checkout-panel">
                        <h2>Cart Items</h2>
                        <div class="checkout-items">
                            <?php foreach ($checkout['items'] as $item): ?>
                                <article class="checkout-item">
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= e(url($item['image_url'])) ?>" alt="<?= e($item['name']) ?>">
                                    <?php else: ?>
                                        <div class="checkout-image-placeholder" aria-hidden="true"></div>
                                    <?php endif; ?>
                                    <div>
                                        <h3><?= e($item['name']) ?></h3>
                                        <p>SKU: <?= e($item['sku']) ?></p>
                                        <p><?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                                    </div>
                                    <strong>₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <aside class="checkout-panel order-summary">
                    <h2>Order Summary</h2>
                    <dl>
                        <div><dt>Subtotal</dt><dd>₱<?= number_format((float) $checkout['totals']['subtotal'], 2) ?></dd></div>
                        <div><dt>Shipping</dt><dd>₱<?= number_format((float) $checkout['totals']['shipping_total'], 2) ?></dd></div>
                        <div><dt>Tax</dt><dd>₱<?= number_format((float) $checkout['totals']['tax_total'], 2) ?></dd></div>
                        <div class="summary-total"><dt>Grand Total</dt><dd>₱<?= number_format((float) $checkout['totals']['grand_total'], 2) ?></dd></div>
                    </dl>
                    <button type="submit" class="confirm-order-btn">Confirm Order</button>
                    <a class="cancel-checkout-btn" href="<?= e($cancelUrl) ?>">Cancel</a>
                    <p class="checkout-note">Stock and prices are checked again when you confirm.</p>
                </aside>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
