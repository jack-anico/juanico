<?php
$pageTitle = ($order ? '#' . e($order['order_number']) : 'Order Not Found') . ' – JUANICO';
$activeNav = '';
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main page-main--narrow">
    <nav style="margin-bottom:2rem;font-size:0.85rem;color:var(--color-text-muted);">
        <a href="<?= url('/orders') ?>" style="color:var(--color-text-muted);text-decoration:none;">&larr; Back to Order History</a>
    </nav>

    <?php if (!$order): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <h1 style="font-size:1.5rem;">Order not found</h1>
            <p>This receipt doesn't exist or doesn't belong to your account.</p>
        </div>
    <?php else: ?>
        <div class="receipt-shell">

            <!-- Receipt Header -->
            <div class="receipt-header">
                <div>
                    <p style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem;">Order Receipt</p>
                    <h1>#<?= e($order['order_number']) ?></h1>
                    <p style="font-size:0.85rem;color:#64748b;margin-top:0.5rem;">
                        <?= e(date('F j, Y · g:i A', strtotime($order['placed_at']))) ?>
                    </p>
                </div>
                <div class="meta" style="text-align:right;">
                    <span class="badge <?= strtolower($order['status']) === 'completed' ? 'badge-success' : 'badge-warning' ?>" style="font-size:0.82rem;padding:0.4rem 1rem;">
                        <?= e(ucfirst($order['status'])) ?>
                    </span>
                </div>
            </div>

            <!-- Receipt Body -->
            <div class="receipt-body">
                <!-- Items + Shipping -->
                <div>
                    <div class="receipt-items">
                        <h2>Items Purchased</h2>
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="receipt-item">
                                <div>
                                    <p class="receipt-item-name"><?= e($item['product_name']) ?></p>
                                    <p class="receipt-item-sku">SKU: <?= e($item['product_sku']) ?></p>
                                    <p class="receipt-item-qty"><?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                                </div>
                                <strong>₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="receipt-shipping" style="margin-top:2rem;">
                        <h2>Shipping Address</h2>
                        <address class="receipt-address" style="font-style:normal;">
                            <strong><?= e($order['shipping_name']) ?></strong><br>
                            <?= e($order['shipping_phone']) ?><br>
                            <?= e($order['shipping_line1']) ?><br>
                            <?php if (!empty($order['shipping_line2'])): ?><?= e($order['shipping_line2']) ?><br><?php endif; ?>
                            <?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?><br>
                            <?= e($order['shipping_country']) ?>
                        </address>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div>
                    <div class="receipt-summary">
                        <h2>Payment Summary</h2>
                        <dl class="summary-rows">
                            <div class="summary-row"><dt>Subtotal</dt><dd>₱<?= number_format((float) $order['subtotal'], 2) ?></dd></div>
                            <div class="summary-row"><dt>Shipping</dt><dd>₱<?= number_format((float) $order['shipping_total'], 2) ?></dd></div>
                            <div class="summary-row"><dt>Tax</dt><dd>₱<?= number_format((float) $order['tax_total'], 2) ?></dd></div>
                            <div class="summary-row total">
                                <dt>Grand Total</dt>
                                <dd>₱<?= number_format((float) $order['grand_total'], 2) ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php if ($order && ($showSuccess ?? false)): ?>
<dialog id="success-modal" style="padding:2.5rem;border:none;border-radius:1.25rem;box-shadow:0 25px 50px rgba(0,0,0,0.2);max-width:420px;text-align:center;font-family:inherit;">
    <div style="font-size:3rem;margin-bottom:1rem;">🎉</div>
    <h2 style="font-size:1.5rem;font-weight:800;color:var(--color-heading);margin-bottom:0.75rem;">Order Confirmed!</h2>
    <p style="color:var(--color-text-muted);margin-bottom:0.5rem;">Order <strong style="color:var(--color-heading);">#<?= e($order['order_number']) ?></strong> has been placed successfully.</p>
    <p style="color:var(--color-text-muted);font-size:0.88rem;margin-bottom:1.5rem;">Your receipt is saved in Order History.</p>
    <button id="close-success" class="btn-primary" style="width:100%;padding:0.85rem;">View Receipt</button>
</dialog>
<style>#success-modal::backdrop { background:rgba(2,6,23,0.65); backdrop-filter:blur(6px); }</style>
<script>
    const m = document.getElementById('success-modal');
    m.showModal();
    document.getElementById('close-success').addEventListener('click', () => m.close());
</script>
<?php endif; ?>

<?php require VIEW_PATH . '/partials/footer.php'; ?>
