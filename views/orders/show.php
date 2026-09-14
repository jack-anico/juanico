<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($order['order_number'] ?? 'Order not found') ?> - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/checkout.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh; background:#f8fafc;">
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
        </div>
    </header>

    <main class="orders-page" style="flex:1; padding: 4rem 5%; max-width: 900px; margin: 0 auto; width:100%;">
        <div style="margin-bottom: 2rem;">
            <a href="<?= url('/orders') ?>" style="color:#64748b; text-decoration:none; font-weight:600; font-size:0.95rem;">&larr; Back to Orders</a>
        </div>

        <?php if (!$order): ?>
            <div class="form-card" style="margin:0; max-width:100%; text-align:center;">
                <h1 style="color:#0f172a;">Order not found</h1>
                <p style="color:#64748b;">This receipt does not exist or does not belong to your account.</p>
            </div>
        <?php else: ?>
            
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05);">
                <!-- Receipt Header -->
                <div style="background:#0f172a; padding:2rem 3rem; color:#fff; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <p style="color:#cbd5e1; font-size:0.85rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.5rem;">Order Receipt</p>
                        <h1 style="font-size:2.5rem; font-weight:800; letter-spacing:-1px; margin:0; color:#fff;">#<?= e($order['order_number']) ?></h1>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge" style="background:rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2); font-size:0.85rem; padding:0.4rem 1rem; margin-bottom:0.5rem;"><?= e(ucfirst($order['status'])) ?></span>
                        <p style="color:#94a3b8; font-size:0.9rem; margin:0;"><?= e(date('F j, Y g:i A', strtotime($order['placed_at']))) ?></p>
                    </div>
                </div>

                <div class="grid-checkout" style="padding: 3rem;">
                    
                    <!-- Items -->
                    <div>
                        <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:1.5rem; border-bottom:1px solid #e2e8f0; padding-bottom:1rem;">Items Purchased</h2>
                        <div style="display:flex; flex-direction:column; gap:1.5rem;">
                            <?php foreach ($order['items'] as $item): ?>
                                <article style="display:flex; justify-content:space-between; align-items:flex-start;">
                                    <div>
                                        <h3 style="font-size:1.05rem; font-weight:600; color:#0f172a; margin-bottom:0.25rem;"><?= e($item['product_name']) ?></h3>
                                        <p style="color:#64748b; font-size:0.85rem; margin:0; margin-bottom:0.5rem;">SKU: <?= e($item['product_sku']) ?></p>
                                        <p style="color:#475569; font-weight:500; font-size:0.95rem; margin:0;"><?= (int) $item['quantity'] ?> × ₱<?= number_format((float) $item['unit_price'], 2) ?></p>
                                    </div>
                                    <strong style="font-size:1.1rem; color:#0f172a; font-weight:800;">₱<?= number_format((float) $item['line_total'], 2) ?></strong>
                                </article>
                            <?php endforeach; ?>
                        </div>

                        <!-- Shipping Address -->
                        <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-top:3rem; margin-bottom:1.5rem; border-bottom:1px solid #e2e8f0; padding-bottom:1rem;">Shipping Details</h2>
                        <address style="font-style:normal; color:#475569; line-height:1.6; background:#f8fafc; padding:1.5rem; border-radius:8px; border:1px solid #e2e8f0;">
                            <strong style="color:#0f172a; display:block; margin-bottom:0.25rem;"><?= e($order['shipping_name']) ?></strong>
                            <?= e($order['shipping_phone']) ?><br>
                            <?= e($order['shipping_line1']) ?><br>
                            <?php if ($order['shipping_line2']): ?><?= e($order['shipping_line2']) ?><br><?php endif; ?>
                            <?= e($order['shipping_city']) ?>, <?= e($order['shipping_state']) ?> <?= e($order['shipping_postal_code']) ?><br>
                            <?= e($order['shipping_country']) ?>
                        </address>
                    </div>

                    <!-- Summary Sidebar -->
                    <div>
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:2rem;">
                            <h2 style="font-size:1.1rem; font-weight:700; color:#0f172a; margin-bottom:1.5rem;">Payment Summary</h2>
                            <dl style="display:flex; flex-direction:column; gap:1rem; margin:0; color:#475569; font-size:0.95rem;">
                                <div style="display:flex; justify-content:space-between;"><dt>Subtotal</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $order['subtotal'], 2) ?></dd></div>
                                <div style="display:flex; justify-content:space-between;"><dt>Shipping</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $order['shipping_total'], 2) ?></dd></div>
                                <div style="display:flex; justify-content:space-between;"><dt>Tax</dt><dd style="font-weight:600; color:#0f172a;">₱<?= number_format((float) $order['tax_total'], 2) ?></dd></div>
                                
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1rem; padding-top:1rem; border-top:1px solid #e2e8f0;">
                                    <dt style="font-weight:800; color:#0f172a; font-size:1.1rem;">Total</dt>
                                    <dd style="font-weight:800; color:#f97316; font-size:1.5rem; margin:0;">₱<?= number_format((float) $order['grand_total'], 2) ?></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php if ($order && $showSuccess): ?>
        <dialog id="purchase-success-modal" style="padding:3rem; border:none; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); max-width:450px; text-align:center;">
            <div style="font-size:3.5rem; margin-bottom:1rem;">🎉</div>
            <h2 id="purchase-success-title" style="color:#0f172a; font-size:1.8rem; font-weight:800; letter-spacing:-0.5px; margin-bottom:1rem;">Order Confirmed!</h2>
            <p style="color:#475569; margin-bottom:0.5rem; font-size:1.05rem;">Your order number is <strong style="color:#0f172a;">#<?= e($order['order_number']) ?></strong>.</p>
            <p style="color:#64748b; font-size:0.9rem; margin-bottom:2rem;">Your receipt is ready and has been saved to your Order History.</p>
            <button type="button" id="close-purchase-success" class="btn-primary" style="width:100%;">View Receipt</button>
        </dialog>
        <style>
            #purchase-success-modal::backdrop { background: rgba(2, 6, 23, 0.7); backdrop-filter: blur(8px); }
        </style>
        <script>
            const successModal = document.getElementById('purchase-success-modal');
            successModal.showModal();
            document.getElementById('close-purchase-success').addEventListener('click', () => successModal.close());
        </script>
    <?php endif; ?>
</body>
</html>
