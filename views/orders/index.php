<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Juanico</title>
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
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="orders-page" style="flex:1; padding: 4rem 5%; max-width: 900px; margin: 0 auto; width:100%;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 2rem;">
            <h1 style="color:#0f172a; font-size:2.2rem; font-weight:800; letter-spacing:-0.5px;">Order History</h1>
        </div>

        <?php if (empty($orders)): ?>
            <div class="form-card" style="margin: 0; max-width: 100%; text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;">📦</div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color:#0f172a;">No orders yet</h2>
                <p style="color: #64748b; margin-bottom: 2rem;">Looks like you haven't placed any orders with us yet.</p>
                <a class="btn-primary" href="<?= url('/products') ?>" style="display:inline-block; width:auto;">Browse Products</a>
            </div>
        <?php else: ?>
            <div style="display:flex; flex-direction:column; gap:1.5rem;">
                <?php foreach ($orders as $order): ?>
                    <article style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:1.5rem 2rem; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 3px rgba(0,0,0,0.05); transition:transform 0.2s, box-shadow 0.2s; cursor:pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)';">
                        <div style="display:flex; flex-direction:column; gap:0.5rem;">
                            <div style="display:flex; align-items:center; gap:1rem;">
                                <h2 style="font-size:1.1rem; color:#0f172a; font-weight:700; margin:0;">#<?= e($order['order_number']) ?></h2>
                                <span class="badge <?= strtolower($order['status']) === 'completed' ? 'badge-success' : 'badge-warning' ?>"><?= e(ucfirst($order['status'])) ?></span>
                            </div>
                            <p style="color:#64748b; font-size:0.9rem; margin:0;"><?= e(date('M j, Y • g:i A', strtotime($order['placed_at']))) ?></p>
                            <p style="color:#475569; font-size:0.9rem; margin:0; font-weight:500;"><?= count($order['items']) ?> item<?= count($order['items']) === 1 ? '' : 's' ?></p>
                        </div>
                        <div style="text-align:right; display:flex; flex-direction:column; gap:0.5rem;">
                            <strong style="font-size:1.5rem; color:#0f172a; font-weight:800;">₱<?= number_format((float) $order['grand_total'], 2) ?></strong>
                            <a href="<?= url('/orders/' . rawurlencode($order['order_number'])) ?>" style="color:#f97316; font-weight:600; text-decoration:none; font-size:0.9rem;">View Receipt &rarr;</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    
    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
