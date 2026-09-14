<?php
$adminTitle  = 'Dashboard';
$adminActive = 'dashboard';
require VIEW_PATH . '/partials/admin_header.php';
?>

<div class="admin-topbar">
    <h1>Dashboard Overview</h1>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <h3>Total Revenue</h3>
        <div class="kpi-value">₱124,500</div>
        <p class="kpi-sub">All time</p>
    </div>
    <div class="kpi-card">
        <h3>Active Orders</h3>
        <div class="kpi-value">12</div>
        <p class="kpi-sub">Pending fulfillment</p>
    </div>
    <div class="kpi-card">
        <h3>Total Products</h3>
        <div class="kpi-value">84</div>
        <p class="kpi-sub">In catalog</p>
    </div>
    <div class="kpi-card">
        <h3>Registered Users</h3>
        <div class="kpi-value">45</div>
        <p class="kpi-sub">Customers</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-table-card" style="padding:2rem;">
    <h2 style="font-size:1.2rem;font-weight:800;color:var(--color-heading);margin-bottom:0.75rem;">Quick Actions</h2>
    <p style="color:var(--color-text-muted);margin-bottom:1.5rem;font-size:0.9rem;">
        Use the sidebar to manage products and view orders. Use the buttons below for common tasks.
    </p>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="<?= url('/admin/products/create') ?>" class="btn-primary">+ Add New Product</a>
        <a href="<?= url('/admin/products') ?>" class="btn-secondary">View All Products</a>
    </div>
</div>

<?php require VIEW_PATH . '/partials/admin_footer.php'; ?>
