<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($order['order_number'] ?? 'Order not found') ?> - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
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
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="orders-page">
        <?php if (!$order): ?>
            <section class="checkout-panel">
                <h1>Order not found</h1>
                <p>This receipt does not exist or does not belong to your account.</p>
            </section>
        <?php else: ?>
            <section class="receipt-heading">
                <div>
                    <p class="receipt-label">Order Receipt</p>
                    <h1><?= e($order['order_number']) ?></h1>
                </div>
                <div>
                    <strong><?= e(ucfirst($order['status'])) ?></strong>
                    <p><?= e(date('F j, Y g:i A', strtotime($order['placed_at']))) ?></p>
                </div>
            </section>

            <div class="receipt-layout">
                <div>
                    <section class="checkout-panel">
                        <h2>Items</h2>
                        <?php foreach ($order['items'] as $item): ?>
                            <article class="receipt-item">
                                <div>
                                    <h3><?= e($item['product_name']) ?></h3>
                                    <p>SKU: <?= e($item['product_sku']) ?></p>
                                    <p><?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                                </div>
                                <strong>₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                            </article>
                        <?php endforeach; ?>
                    </section>

                    <section class="checkout-panel">
                        <h2>Shipping Address</h2>
                        <address>
                            <strong><?= e($order['shipping_name']) ?></strong><br>
                            <?= e($order['shipping_phone']) ?><br>
                            <?= e($order['shipping_line1']) ?><br>
                            <?php if ($order['shipping_line2']): ?><?= e($order['shipping_line2']) ?><br><?php endif; ?>
                            <?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?><br>
                            <?= e($order['shipping_country']) ?>
                        </address>
                    </section>
                </div>

                <aside class="checkout-panel order-summary">
                    <h2>Order Summary</h2>
                    <dl>
                        <div><dt>Subtotal</dt><dd>₱<?= number_format((float) $order['subtotal'], 2) ?></dd></div>
                        <div><dt>Shipping</dt><dd>₱<?= number_format((float) $order['shipping_total'], 2) ?></dd></div>
                        <div><dt>Tax</dt><dd>₱<?= number_format((float) $order['tax_total'], 2) ?></dd></div>
                        <div class="summary-total"><dt>Grand Total</dt><dd>₱<?= number_format((float) $order['grand_total'], 2) ?></dd></div>
                    </dl>
                </aside>
            </div>
        <?php endif; ?>
    </main>

    <?php if ($order && $showSuccess): ?>
        <dialog id="purchase-success-modal" class="purchase-success-modal" aria-labelledby="purchase-success-title">
            <h2 id="purchase-success-title">Purchased Successfully!</h2>
            <p>Your order number is <strong><?= e($order['order_number']) ?></strong>.</p>
            <p>Your receipt is ready below, and it is saved in Order History.</p>
            <button type="button" id="close-purchase-success">View Receipt</button>
        </dialog>
        <script>
            const successModal = document.getElementById('purchase-success-modal');
            successModal.showModal();
            document.getElementById('close-purchase-success').addEventListener('click', () => successModal.close());
        </script>
    <?php endif; ?>
</body>
</html>
