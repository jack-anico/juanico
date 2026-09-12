<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Juanico</title>
</head>
<body>
    <h1>Products</h1>
    <a href="<?= url('/') ?>">Back to Home</a>
    <br><br>

    <?php if (empty($products)): ?>
        <p>No products available at the moment.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div>
                <?php if (!empty($product['images'])): ?>
                    <img src="<?= url($product['images'][0]['url']) ?>" alt="<?= e($product['name']) ?>" width="200">
                <?php endif; ?>
                <h2><?= e($product['name']) ?></h2>
                <p>Price: ₱<?= e(number_format((float) $product['price'], 2)) ?></p>
                <p>Stock: <?= e((string) $product['stock_quantity']) ?></p>
                <?php if (!empty($product['description'])): ?>
                    <p><?= e($product['description']) ?></p>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
