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
                <h1>Manage Products</h1>
                <div>
                    <a href="<?= url('/admin/products/create') ?>" class="btn-primary">+ Add New Product</a>
                </div>
            </div>

            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error"><?= e($generalError) ?></div>
            <?php endif; ?>

            <div class="admin-table-card">
                <?php if (empty($products)): ?>
                    <div style="padding:2rem; color:#666;">No products found.</div>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= e((string) $product['product_id']) ?></td>
                                    <td>
                                        <?php if (!empty($product['images'])): ?>
                                            <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" width="40" height="40" style="object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                                        <?php else: ?>
                                            <span style="color:#999; font-size:0.8rem;">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-weight:600; color:#1a252c;"><?= e($product['name']) ?></td>
                                    <td><?= e($product['sku']) ?></td>
                                    <td>₱<?= e(number_format((float) $product['price'], 2)) ?></td>
                                    <td>
                                        <?php if ($product['stock_quantity'] > 0): ?>
                                            <?= e((string) $product['stock_quantity']) ?>
                                        <?php else: ?>
                                            <span class="status-inactive">Out</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($product['is_active']): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">No</span>
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
