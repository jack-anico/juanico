<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>admin dashboard</h1>
    <p>Welcome, Admin!</p>
    
    <form action="<?= url('/logout') ?>" method="POST" style="display:inline;">
        <?= csrf_field() ?>
        <button type="submit">Logout</button>
    </form>
</body>
</html>
