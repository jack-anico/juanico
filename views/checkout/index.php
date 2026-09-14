<?php
$pageTitle = 'Checkout – JUANICO';
$activeNav = '';
$extraCss  = [url('/assets/css/cart.css'), url('/assets/css/checkout.css')];
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main page-main--narrow">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--color-heading);margin-bottom:2rem;">Checkout</h1>

    <?php if ($allErrors = errors()): ?>
        <div class="alert alert-error" role="alert" style="margin-bottom:1.5rem;">
            <strong>Please fix the following:</strong>
            <ul style="margin-left:1.25rem;margin-top:0.5rem;">
                <?php foreach ($allErrors as $error): ?>
                    <li><?= e((string) $error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($checkout['items'])): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🛒</div>
            <h2>Your cart is empty</h2>
            <p>Add at least one product before checking out.</p>
            <a href="<?= url('/products') ?>" class="btn-primary" style="display:inline-block;margin-top:1rem;">Browse Products</a>
        </div>
    <?php else: ?>
        <form action="<?= url('/checkout/confirm') ?>" method="POST" class="checkout-layout">
            <?= csrf_field() ?>
            <input type="hidden" name="return_to" value="<?= e($returnUrl) ?>">

            <!-- Left column -->
            <div>
                <!-- Shipping Address -->
                <div class="checkout-panel">
                    <h2>Shipping Address</h2>
                    <div class="shipping-grid">
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_name">Full name</label>
                            <input type="text" id="shipping_name" name="shipping_name" class="form-input"
                                   maxlength="150" required autocomplete="name"
                                   value="<?= old('shipping_name', $user['username'] ?? '') ?>">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_phone">Phone</label>
                            <input type="tel" id="shipping_phone" name="shipping_phone" class="form-input"
                                   maxlength="30" required autocomplete="tel"
                                   value="<?= old('shipping_phone', $user['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group full" style="margin:0;">
                            <label for="shipping_line1">Address line 1</label>
                            <input type="text" id="shipping_line1" name="shipping_line1" class="form-input"
                                   maxlength="255" required autocomplete="address-line1"
                                   value="<?= old('shipping_line1') ?>">
                        </div>
                        <div class="form-group full" style="margin:0;">
                            <label for="shipping_line2">Address line 2 <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                            <input type="text" id="shipping_line2" name="shipping_line2" class="form-input"
                                   maxlength="255" autocomplete="address-line2"
                                   value="<?= old('shipping_line2') ?>">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_city">City</label>
                            <input type="text" id="shipping_city" name="shipping_city" class="form-input"
                                   maxlength="100" required autocomplete="address-level2"
                                   value="<?= old('shipping_city') ?>">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_state">State / Province</label>
                            <input type="text" id="shipping_state" name="shipping_state" class="form-input"
                                   maxlength="100" required autocomplete="address-level1"
                                   value="<?= old('shipping_state') ?>">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_postal_code">Postal code</label>
                            <input type="text" id="shipping_postal_code" name="shipping_postal_code" class="form-input"
                                   maxlength="20" required autocomplete="postal-code"
                                   value="<?= old('shipping_postal_code') ?>">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label for="shipping_country">Country</label>
                            <input type="text" id="shipping_country" name="shipping_country" class="form-input"
                                   maxlength="100" required autocomplete="country-name"
                                   value="<?= old('shipping_country', 'Philippines') ?>">
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="checkout-panel">
                    <h2>Order Items</h2>
                    <?php foreach ($checkout['items'] as $item): ?>
                        <div class="checkout-item">
                            <?php if ($item['image_url']): ?>
                                <img src="<?= e(url($item['image_url'])) ?>" alt="<?= e($item['name']) ?>">
                            <?php else: ?>
                                <div class="checkout-item-placeholder"></div>
                            <?php endif; ?>
                            <div class="checkout-item-info">
                                <h3><?= e($item['name']) ?></h3>
                                <p>SKU: <?= e($item['sku']) ?> &nbsp;·&nbsp; <?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                            </div>
                            <strong>₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right column - sticky summary -->
            <aside>
                <div class="order-summary-panel">
                    <h2>Order Summary</h2>
                    <dl class="summary-rows">
                        <div class="summary-row"><dt>Subtotal</dt><dd>₱<?= number_format((float) $checkout['totals']['subtotal'], 2) ?></dd></div>
                        <div class="summary-row"><dt>Shipping</dt><dd>₱<?= number_format((float) $checkout['totals']['shipping_total'], 2) ?></dd></div>
                        <div class="summary-row"><dt>Tax</dt><dd>₱<?= number_format((float) $checkout['totals']['tax_total'], 2) ?></dd></div>
                        <div class="summary-row total">
                            <dt>Grand Total</dt>
                            <dd>₱<?= number_format((float) $checkout['totals']['grand_total'], 2) ?></dd>
                        </div>
                    </dl>
                    <button type="submit" class="btn-primary" style="width:100%;padding:0.9rem;font-size:1rem;margin-top:1.5rem;">
                        Confirm Order
                    </button>
                    <a href="<?= e($cancelUrl) ?>" class="btn-ghost" style="width:100%;justify-content:center;margin-top:0.75rem;">
                        Cancel
                    </a>
                    <p class="summary-note">Stock and prices are verified again at confirmation.</p>
                </div>
            </aside>
        </form>
    <?php endif; ?>
</main>

<?php require VIEW_PATH . '/partials/footer.php'; ?>
