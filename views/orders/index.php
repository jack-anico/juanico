<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/checkout.css') ?>">
</head>
<body>
    <header class="checkout-header">
        <a href="<?= url('/products') ?>">← Products</a>
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
