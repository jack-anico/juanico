<?php
$adminTitle  = 'Edit Product';
$adminActive = 'products';
require VIEW_PATH . '/partials/admin_header.php';
?>

<div class="admin-topbar">
    <div>
        <a href="<?= url('/admin/products') ?>" style="font-size:0.85rem;color:var(--color-text-muted);text-decoration:none;">&larr; Back to Products</a>
        <h1 style="margin-top:0.4rem;">Edit Product</h1>
    </div>
</div>

<?php if ($generalError = errors('general')): ?>
    <div class="alert alert-error" style="margin-bottom:1.5rem;"><?= e($generalError) ?></div>
<?php endif; ?>

<div class="admin-form-card">
    <form action="<?= url('/admin/products/update/' . $product['product_id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <h2>Product Information</h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
            <div class="form-group" style="margin:0;">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-input"
                       value="<?= e(old('name') ?: $product['name']) ?>" required>
                <?php if (hasError('name')): ?><span class="form-error"><?= e(errors('name')) ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="margin:0;">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" class="form-input"
                       value="<?= e(old('sku') ?: $product['sku']) ?>" required>
                <?php if (hasError('sku')): ?><span class="form-error"><?= e(errors('sku')) ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="margin:0;grid-column:1/-1;">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-input" rows="4"><?= e(old('description') ?: ($product['description'] ?? '')) ?></textarea>
                <?php if (hasError('description')): ?><span class="form-error"><?= e(errors('description')) ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="margin:0;">
                <label for="price">Price (₱)</label>
                <input type="number" id="price" name="price" class="form-input" step="0.01" min="0"
                       value="<?= e(old('price') ?: $product['price']) ?>" required>
                <?php if (hasError('price')): ?><span class="form-error"><?= e(errors('price')) ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="margin:0;">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" class="form-input" min="0"
                       value="<?= e(old('stock_quantity') ?: (string) $product['stock_quantity']) ?>" required>
                <?php if (hasError('stock_quantity')): ?><span class="form-error"><?= e(errors('stock_quantity')) ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="margin:0;">
                <label for="is_active">Status</label>
                <?php $activeVal = old('is_active') !== '' ? old('is_active') : (string) $product['is_active']; ?>
                <select id="is_active" name="is_active" class="form-input">
                    <option value="1" <?= $activeVal !== '0' ? 'selected' : '' ?>>Active (visible to customers)</option>
                    <option value="0" <?= $activeVal === '0' ? 'selected' : '' ?>>Draft (hidden)</option>
                </select>
            </div>
            <div class="form-group" style="margin:0;grid-column:1/-1;">
                <label>Product Image</label>
                <?php if (!empty($product['images'])): ?>
                    <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:0.75rem;padding:1rem;background:#f8fafc;border:1px solid var(--color-border);border-radius:var(--radius-md);">
                        <img src="<?= e(url($product['images'][0]['url'])) ?>" alt="<?= e($product['name']) ?>"
                             style="width:80px;height:80px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--color-border);">
                        <div>
                            <p style="font-size:0.85rem;font-weight:600;color:var(--color-heading);margin-bottom:0.2rem;">Current Image</p>
                            <p style="font-size:0.78rem;color:var(--color-text-muted);">Upload a new image below to replace it</p>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*" style="display:block;font-size:0.88rem;">
                <?php if (hasError('image')): ?><span class="form-error"><?= e(errors('image')) ?></span><?php endif; ?>
            </div>
        </div>

        <div style="margin-top:2rem;display:flex;gap:1rem;">
            <button type="submit" class="btn-primary" style="padding:0.8rem 2rem;">Save Changes</button>
            <a href="<?= url('/admin/products') ?>" class="btn-secondary" style="padding:0.8rem 2rem;">Cancel</a>
        </div>
    </form>
</div>

<?php require VIEW_PATH . '/partials/admin_footer.php'; ?>
