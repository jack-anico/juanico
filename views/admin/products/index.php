<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Juanico Admin</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <a href="<?= url('/') ?>" class="admin-brand">JUANICO <span>Admin</span></a>
            <ul class="admin-nav">
                <li><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= url('/admin/products') ?>" class="active">Products</a></li>
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
                <h1>Product Inventory</h1>
                <div>
                    <a href="<?= url('/admin/products/create') ?>" class="btn-primary">+ Add New Product</a>
                </div>
            </div>

            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error"><?= e($generalError) ?></div>
            <?php endif; ?>

            <div class="admin-table-card">
                <?php if (empty($products)): ?>
                    <div style="padding:4rem; text-align:center; color:#64748b;">
                        <div style="font-size:3rem; margin-bottom:1rem;">📦</div>
                        <h2>No products found</h2>
                        <p>Get started by adding your first product.</p>
                    </div>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:1rem;">
                                            <?php if (!empty($product['images'])): ?>
                                                <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" style="width:48px; height:48px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0; background:#f1f5f9;">
                                            <?php else: ?>
                                                <div style="width:48px; height:48px; border-radius:8px; background:#f1f5f9; border:1px solid #e2e8f0;"></div>
                                            <?php endif; ?>
                                            <div>
                                                <div style="font-weight:700; color:#0f172a; margin-bottom:0.25rem;"><?= e($product['name']) ?></div>
                                                <div style="font-size:0.8rem; color:#64748b;">ID: <?= e((string) $product['product_id']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color:#475569; font-weight:500; font-size:0.9rem;"><?= e($product['sku']) ?></td>
                                    <td style="font-weight:700; color:#0f172a;">₱<?= e(number_format((float) $product['price'], 2)) ?></td>
                                    <td>
                                        <?php if ($product['stock_quantity'] > 0): ?>
                                            <span style="font-weight:600; color:#475569;"><?= e((string) $product['stock_quantity']) ?></span>
                                        <?php else: ?>
                                            <span class="status-inactive">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($product['is_active']): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="action-links">
                                        <div style="display:flex; align-items:center;">
                                            <a href="<?= url('/admin/products/edit/' . $product['product_id']) ?>" class="edit">Edit</a>
                                            <form action="<?= url('/admin/products/delete/' . $product['product_id']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin:0;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="delete">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
