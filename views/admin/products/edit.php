<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Juanico Admin</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body>
    <div class="admin-layout">
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

        <main class="admin-content">
            <div class="admin-header" style="margin-bottom:1.5rem;">
                <h1>Edit Product</h1>
                <div>
                    <a href="<?= url('/admin/products') ?>" style="color:#666; text-decoration:none; font-weight:600;">&larr; Back to Products</a>
                </div>
            </div>

            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error"><?= e($generalError) ?></div>
            <?php endif; ?>

            <div class="admin-table-card" style="padding:2.5rem; max-width:800px;">
                <form action="<?= url('/admin/products/update/' . $product['product_id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" id="name" name="name" class="form-input" value="<?= e(old('name') ?: $product['name']) ?>" required>
                            <?php if (hasError('name')): ?><span class="form-error"><?= e(errors('name')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU:</label>
                            <input type="text" id="sku" name="sku" class="form-input" value="<?= e(old('sku') ?: $product['sku']) ?>" required>
                            <?php if (hasError('sku')): ?><span class="form-error"><?= e(errors('sku')) ?></span><?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-input" rows="4"><?= e(old('description') ?: ($product['description'] ?? '')) ?></textarea>
                        <?php if (hasError('description')): ?><span class="form-error"><?= e(errors('description')) ?></span><?php endif; ?>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1.5rem;">
                        <div class="form-group">
                            <label for="price">Price (₱):</label>
                            <input type="number" id="price" name="price" class="form-input" step="0.01" min="0" value="<?= e(old('price') ?: $product['price']) ?>" required>
                            <?php if (hasError('price')): ?><span class="form-error"><?= e(errors('price')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity:</label>
                            <input type="number" id="stock_quantity" name="stock_quantity" class="form-input" min="0" value="<?= e(old('stock_quantity') ?: (string) $product['stock_quantity']) ?>" required>
                            <?php if (hasError('stock_quantity')): ?><span class="form-error"><?= e(errors('stock_quantity')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="is_active">Status:</label>
                            <select id="is_active" name="is_active" class="form-input">
                                <?php $activeVal = old('is_active') !== null ? old('is_active') : $product['is_active']; ?>
                                <option value="1" <?= $activeVal != '0' ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $activeVal == '0' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:100px 1fr; gap:1.5rem; margin-top:1.5rem;">
                        <?php if (!empty($product['images'])): ?>
                            <div>
                                <label style="font-weight:600; color:#1a252c; font-size:0.9rem;">Current:</label><br>
                                <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" style="width:100px; height:100px; object-fit:cover; border:1px solid #ddd; border-radius:4px; margin-top:0.4rem;">
                            </div>
                        <?php endif; ?>

                        <div class="form-group" style="align-self:center;">
                            <label for="image">Upload New Image (optional):</label>
                            <input type="file" id="image" name="image" accept="image/*" style="display:block; margin-top:0.5rem;">
                            <?php if (hasError('image')): ?><span class="form-error"><?= e(errors('image')) ?></span><?php endif; ?>
                        </div>
                    </div>

                    <div style="margin-top:2.5rem;">
                        <button type="submit" class="btn-primary" style="padding:0.8rem 2rem; border:none; cursor:pointer;">Update Product</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
