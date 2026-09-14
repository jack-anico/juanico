<?php
$adminTitle  = 'Products';
$adminActive = 'products';
require VIEW_PATH . '/partials/admin_header.php';
?>

<div class="admin-topbar">
    <h1>Product Inventory</h1>
    <a href="<?= url('/admin/products/create') ?>" class="btn-primary">+ Add Product</a>
</div>

<?php if ($generalError = errors('general')): ?>
    <div class="alert alert-error" style="margin-bottom:1.5rem;"><?= e($generalError) ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="admin-table-card-header">
        <h2><?= count($products) ?> Products</h2>
    </div>
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <h2>No products yet</h2>
            <p>Start building your catalog by adding a product.</p>
            <a href="<?= url('/admin/products/create') ?>" class="btn-primary" style="display:inline-block;margin-top:1rem;">Add First Product</a>
        </div>
    <?php else: ?>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
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
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    <?php if (!empty($product['images'])): ?>
                                        <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>"
                                             style="width:44px;height:44px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--color-border);background:#f1f5f9;flex-shrink:0;">
                                    <?php else: ?>
                                        <div style="width:44px;height:44px;border-radius:var(--radius-md);background:#f1f5f9;border:1px solid var(--color-border);flex-shrink:0;"></div>
                                    <?php endif; ?>
                                    <div>
                                        <strong style="display:block;font-size:0.9rem;color:var(--color-heading);"><?= e($product['name']) ?></strong>
                                        <span style="font-size:0.75rem;color:var(--color-text-muted);">ID: <?= e((string) $product['product_id']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.85rem;color:var(--color-text-muted);"><?= e($product['sku']) ?></td>
                            <td style="font-weight:700;color:var(--color-heading);">₱<?= number_format((float) $product['price'], 2) ?></td>
                            <td>
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <span style="font-weight:600;"><?= (int) $product['stock_quantity'] ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['is_active']): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="<?= url('/admin/products/edit/' . $product['product_id']) ?>" class="edit">Edit</a>
                                    <form action="<?= url('/admin/products/delete/' . $product['product_id']) ?>" method="POST"
                                          onsubmit="return confirm('Delete this product? This cannot be undone.');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require VIEW_PATH . '/partials/admin_footer.php'; ?>
