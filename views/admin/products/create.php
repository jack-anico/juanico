<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin</title>
</head>
<body>
    <h1>Add Product</h1>
    <a href="<?= url('/admin/products') ?>">Back to Manage Products</a>
    <br><br>

    <?php if ($generalError = errors('general')): ?>
        <div><?= e($generalError) ?></div>
    <?php endif; ?>

    <form action="<?= url('/admin/products') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div>
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" value="<?= old('name') ?>" required>
            <?php if (hasError('name')): ?>
                <div><?= e(errors('name')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="sku">SKU:</label><br>
            <input type="text" id="sku" name="sku" value="<?= old('sku') ?>" required>
            <?php if (hasError('sku')): ?>
                <div><?= e(errors('sku')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="5" cols="40"><?= old('description') ?></textarea>
            <?php if (hasError('description')): ?>
                <div><?= e(errors('description')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= old('price') ?>" required>
            <?php if (hasError('price')): ?>
                <div><?= e(errors('price')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="stock_quantity">Stock Quantity:</label><br>
            <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?= old('stock_quantity') ?? '0' ?>" required>
            <?php if (hasError('stock_quantity')): ?>
                <div><?= e(errors('stock_quantity')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="is_active">Active:</label>
            <select id="is_active" name="is_active">
                <option value="1" <?= old('is_active') !== '0' ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= old('is_active') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>

        <div>
            <label for="image">Product Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if (hasError('image')): ?>
                <div><?= e(errors('image')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <button type="submit">Create Product</button>
        </div>
    </form>
</body>
</html>
