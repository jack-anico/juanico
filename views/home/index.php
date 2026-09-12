<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Juanico</title>
</head>
<body>
    <h1>HOME</h1>
    
    <?php if (isAuthenticated()): ?>
        <p>Welcome, User #<?= e((string)authUserId()) ?>!</p>
        
        <form action="<?= url('/logout') ?>" method="POST" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="<?= url('/login') ?>">Login</a> | 
        <a href="<?= url('/register') ?>">Register</a>
    <?php endif; ?>
</body>
</html>
