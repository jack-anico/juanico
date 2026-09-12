<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
</head>
<body>
    <h1>Manage Products</h1>
    <a href="<?= url('/admin/products/create') ?>">Add New Product</a>
    <a href="<?= url('/admin/dashboard') ?>">Back to Dashboard</a>
    <br><br>

    <?php if ($generalError = errors('general')): ?>
        <div><?= e($generalError) ?></div>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
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
                                <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" width="60">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td><?= e($product['name']) ?></td>
                        <td><?= e($product['sku']) ?></td>
                        <td><?= e(number_format((float) $product['price'], 2)) ?></td>
                        <td><?= e((string) $product['stock_quantity']) ?></td>
                        <td><?= $product['is_active'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="<?= url('/admin/products/edit/' . $product['product_id']) ?>">Edit</a>

                            <form action="<?= url('/admin/products/delete/' . $product['product_id']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <?= csrf_field() ?>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
