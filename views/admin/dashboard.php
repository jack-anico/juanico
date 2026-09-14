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
            <div style="margin-top:auto; padding:2rem;">
                <form action="<?= url('/logout') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-secondary" style="width:100%; border-color:#475569; color:#cbd5e1;">LOGOUT</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard Overview</h1>
                <div style="display:flex; align-items:center; gap:1rem;">
                    <div class="avatar"></div>
                    <div>
                        <p style="color:#0f172a; font-weight:600; font-size:0.95rem; margin:0;">Super Admin</p>
                        <p style="color:#64748b; font-size:0.8rem; margin:0;">Welcome back!</p>
                    </div>
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

            <div class="admin-table-card" style="padding:3rem;">
                <h2 style="color:#0f172a; margin-bottom:1rem; font-size:1.8rem; font-weight:800; letter-spacing:-0.5px;">Quick Actions</h2>
                <p style="color:#64748b; margin-bottom:2rem; font-size:1.05rem;">Use the sidebar navigation to manage products, view orders, and administer the Juanico storefront.</p>
                <div style="display:flex; gap:1rem;">
                    <a href="<?= url('/admin/products/create') ?>" class="btn-primary">+ Add New Product</a>
                    <a href="<?= url('/admin/products') ?>" class="btn-secondary">View Inventory</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
