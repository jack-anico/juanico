<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Juanico</title>
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
                    <li><a href="<?= url('/#services') ?>">SERVICES</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#projects') ?>">PROJECTS</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="orders-page">
        <h1>Order History</h1>

        <?php if (empty($orders)): ?>
            <section class="checkout-panel">
                <p>You have not placed any orders yet.</p>
                <a class="checkout-primary-link" href="<?= url('/products') ?>">Browse Products</a>
            </section>
        <?php else: ?>
            <div class="order-list">
                <?php foreach ($orders as $order): ?>
                    <article class="checkout-panel order-card">
                        <div>
                            <h2><?= e($order['order_number']) ?></h2>
                            <p><?= e(date('F j, Y g:i A', strtotime($order['placed_at']))) ?></p>
                            <p><?= count($order['items']) ?> product<?= count($order['items']) === 1 ? '' : 's' ?> · <?= e(ucfirst($order['status'])) ?></p>
                        </div>
                        <div class="order-card-total">
                            <strong>₱<?= number_format((float) $order['grand_total'], 2) ?></strong>
                            <a href="<?= url('/orders/' . rawurlencode($order['order_number'])) ?>">View Receipt</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
