<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Juanico Admin</title>
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
                <h1>Add New Product</h1>
                <div>
                    <a href="<?= url('/admin/products') ?>" style="color:#666; text-decoration:none; font-weight:600;">&larr; Back to Products</a>
                </div>
            </div>

            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error"><?= e($generalError) ?></div>
            <?php endif; ?>

            <div class="admin-table-card" style="padding:2.5rem; max-width:800px;">
                <form action="<?= url('/admin/products') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" id="name" name="name" class="form-input" value="<?= old('name') ?>" required>
                            <?php if (hasError('name')): ?><span class="form-error"><?= e(errors('name')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU:</label>
                            <input type="text" id="sku" name="sku" class="form-input" value="<?= old('sku') ?>" required>
                            <?php if (hasError('sku')): ?><span class="form-error"><?= e(errors('sku')) ?></span><?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-input" rows="4"><?= old('description') ?></textarea>
                        <?php if (hasError('description')): ?><span class="form-error"><?= e(errors('description')) ?></span><?php endif; ?>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1.5rem;">
                        <div class="form-group">
                            <label for="price">Price (₱):</label>
                            <input type="number" id="price" name="price" class="form-input" step="0.01" min="0" value="<?= old('price') ?>" required>
                            <?php if (hasError('price')): ?><span class="form-error"><?= e(errors('price')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity:</label>
                            <input type="number" id="stock_quantity" name="stock_quantity" class="form-input" min="0" value="<?= old('stock_quantity') ?? '0' ?>" required>
                            <?php if (hasError('stock_quantity')): ?><span class="form-error"><?= e(errors('stock_quantity')) ?></span><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="is_active">Status:</label>
                            <select id="is_active" name="is_active" class="form-input">
                                <option value="1" <?= old('is_active') !== '0' ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= old('is_active') === '0' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:1rem;">
                        <label for="image">Product Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" style="display:block; margin-top:0.5rem;">
                        <?php if (hasError('image')): ?><span class="form-error"><?= e(errors('image')) ?></span><?php endif; ?>
                    </div>

                    <div style="margin-top:2.5rem;">
                        <button type="submit" class="btn-primary" style="padding:0.8rem 2rem; border:none; cursor:pointer;">Create Product</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
