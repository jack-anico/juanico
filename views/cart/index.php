<?php
$pageTitle = 'Your Cart – JUANICO';
$activeNav = '';
$extraCss  = [url('/assets/css/cart.css')];
require VIEW_PATH . '/partials/header.php';
?>

<main class="page-main page-main--narrow">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--color-heading);margin-bottom:2rem;">Your Cart</h1>
    <div class="empty-state" style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);">
        <div class="empty-state-icon">🛒</div>
        <h2>Manage your cart</h2>
        <p>Click the cart button in the header to open your cart drawer and manage your items from any page.</p>
        <a href="<?= url('/products') ?>" class="btn-primary" style="display:inline-block;margin-top:1rem;">Browse Products</a>
    </div>
</main>

<?php
$cartProducts = [];
require VIEW_PATH . '/products/_cart.php';
require VIEW_PATH . '/partials/footer.php';
?>
