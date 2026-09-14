<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <a href="<?= url('/') ?>" class="admin-brand">JUANICO <span>Admin</span></a>
            <ul class="admin-nav">
                <li><a href="<?= url('/admin/dashboard') ?>" class="active">Dashboard</a></li>
                <li><a href="<?= url('/admin/products') ?>">Products</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Users</a></li>
            </ul>
            <div style="margin-top:auto; padding:1.5rem;">
                <form action="<?= url('/logout') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-secondary" style="width:100%; font-size:0.85rem; padding:0.6rem; cursor:pointer;">LOGOUT</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <div>
                    <span style="color:#666; font-weight:600;">Welcome, Admin!</span>
                </div>
            </div>

            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <h3>Total Revenue</h3>
                    <div class="kpi-value">₱124,500</div>
                </div>
                <div class="kpi-card">
                    <h3>Active Orders</h3>
                    <div class="kpi-value">12</div>
                </div>
                <div class="kpi-card">
                    <h3>Total Products</h3>
                    <div class="kpi-value">84</div>
                </div>
                <div class="kpi-card">
                    <h3>Registered Users</h3>
                    <div class="kpi-value">45</div>
                </div>
            </div>

            <div class="admin-table-card" style="padding:2rem;">
                <h2 style="color:#1a252c; margin-bottom:1rem;">Welcome to the Admin Panel</h2>
                <p style="color:#666;">Use the sidebar navigation to manage products, view orders, and administer the Juanico storefront.</p>
                <br>
                <a href="<?= url('/admin/products/create') ?>" class="btn-primary" style="display:inline-block;">+ Add New Product</a>
            </div>
        </main>
    </div>
</body>
</html>
