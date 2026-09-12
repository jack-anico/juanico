<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juanico</title>
</head>
<body>
    <h1>Login</h1>
    
    <?php if ($generalError = errors('general')): ?>
        <div>
            <?= e($generalError) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($csrfError = errors('csrf')): ?>
        <div>
            <?= e($csrfError) ?>
        </div>
    <?php endif; ?>

    <form action="<?= url('/login') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div>
            <label for="identifier">Username or Email:</label><br>
            <input type="text" id="identifier" name="identifier" value="<?= old('identifier') ?>" required>
            <?php if (hasError('identifier')): ?>
                <div><?= e(errors('identifier')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            <?php if (hasError('password')): ?>
                <div><?= e(errors('password')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    
    <p>Don't have an account? <a href="<?= url('/register') ?>">Register</a></p>
</body>
</html>
