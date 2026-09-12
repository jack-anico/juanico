<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Juanico</title>
</head>
<body>
    <h1>Register</h1>
    
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

    <form action="<?= url('/register') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?= old('username') ?>" required>
            <?php if (hasError('username')): ?>
                <div><?= e(errors('username')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
            <?php if (hasError('email')): ?>
                <div><?= e(errors('email')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <label for="phone">Phone (Optional):</label><br>
            <input type="text" id="phone" name="phone" value="<?= old('phone') ?>">
            <?php if (hasError('phone')): ?>
                <div><?= e(errors('phone')) ?></div>
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
            <label for="password_confirmation">Confirm Password:</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <?php if (hasError('password_confirmation')): ?>
                <div><?= e(errors('password_confirmation')) ?></div>
            <?php endif; ?>
        </div>
        <br>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</body>
</html>
