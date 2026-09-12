<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
</head>
<body>
    <h1>Edit Product</h1>
    <a href="<?= url('/admin/products') ?>">Back to Manage Products</a>
    <br><br>

    <?php if ($generalError = errors('general')): ?>
        <div><?= e($generalError) ?></div>
    <?php endif; ?>

    <form action="<?= url('/admin/products/update/' . $product['product_id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div>
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" value="<?= e(old('name') ?: $product['name']) ?>" required>
            <?php if (hasError('name')): ?>
                <div><?= e(errors('name')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="sku">SKU:</label><br>
            <input type="text" id="sku" name="sku" value="<?= e(old('sku') ?: $product['sku']) ?>" required>
            <?php if (hasError('sku')): ?>
                <div><?= e(errors('sku')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="5" cols="40"><?= e(old('description') ?: ($product['description'] ?? '')) ?></textarea>
            <?php if (hasError('description')): ?>
                <div><?= e(errors('description')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= e(old('price') ?: $product['price']) ?>" required>
            <?php if (hasError('price')): ?>
                <div><?= e(errors('price')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="stock_quantity">Stock Quantity:</label><br>
            <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?= e(old('stock_quantity') ?: (string) $product['stock_quantity']) ?>" required>
            <?php if (hasError('stock_quantity')): ?>
                <div><?= e(errors('stock_quantity')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="is_active">Active:</label>
            <select id="is_active" name="is_active">
                <?php $activeVal = old('is_active') !== null ? old('is_active') : $product['is_active']; ?>
                <option value="1" <?= $activeVal != '0' ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= $activeVal == '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>

        <?php if (!empty($product['images'])): ?>
            <div>
                <label>Current Image:</label><br>
                <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" width="150">
            </div>
            <br>
        <?php endif; ?>

        <div>
            <label for="image">Upload New Image (optional):</label><br>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if (hasError('image')): ?>
                <div><?= e(errors('image')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <button type="submit">Update Product</button>
        </div>
    </form>
</body>
</html>
