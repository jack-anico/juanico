<?php
$pageTitle = 'Order History – JUANICO';
$activeNav = '';
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main page-main--narrow">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
        <h1 style="font-size:1.75rem;font-weight:800;color:var(--color-heading);">Order History</h1>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h2>No orders yet</h2>
            <p>You haven't placed any orders with us yet.</p>
            <a href="<?= url('/products') ?>" class="btn-primary" style="display:inline-block;margin-top:1rem;">Browse Products</a>
        </div>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-card-meta">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
                            <h2>#<?= e($order['order_number']) ?></h2>
                            <span class="badge <?= strtolower($order['status']) === 'completed' ? 'badge-success' : 'badge-warning' ?>">
                                <?= e(ucfirst($order['status'])) ?>
                            </span>
                        </div>
                        <p><?= e(date('M j, Y · g:i A', strtotime($order['placed_at']))) ?></p>
                        <p style="margin-top:0.2rem;"><?= count($order['items']) ?> item<?= count($order['items']) !== 1 ? 's' : '' ?></p>
                    </div>
                    <div class="order-card-right">
                        <strong>₱<?= number_format((float) $order['grand_total'], 2) ?></strong>
                        <a href="<?= url('/orders/' . rawurlencode($order['order_number'])) ?>">View Receipt →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require VIEW_PATH . '/partials/footer.php'; ?>
