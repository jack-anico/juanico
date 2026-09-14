<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In – JUANICO</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;">

<main class="auth-page">
    <div class="form-card">
        <div class="form-card-header">
            <a href="<?= url('/') ?>" class="brand-mark">JUAN<span>I</span>CO</a>
            <h1>Welcome back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <?php if ($generalError = errors('general')): ?>
            <div class="alert alert-error" role="alert"><?= e($generalError) ?></div>
        <?php endif; ?>

        <form action="<?= url('/login') ?>" method="POST" id="loginForm" novalidate>
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="identifier">Email or Username</label>
                <input
                    type="text"
                    id="identifier"
                    name="identifier"
                    class="form-input"
                    value="<?= old('identifier') ?>"
                    required
                    autocomplete="username"
                    autofocus
                    placeholder="you@example.com"
                >
                <span class="form-error" id="identifierError">
                    <?php if (hasError('identifier')) echo e(errors('identifier')); ?>
                </span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
                <span class="form-error" id="passwordError">
                    <?php if (hasError('password')) echo e(errors('password')); ?>
                </span>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn-primary" style="width:100%;padding:0.85rem;font-size:1rem;">Sign In</button>
            </div>
        </form>

        <div class="form-footer mt-2">
            Don't have an account? <a href="<?= url('/register') ?>">Create one</a>
        </div>
    </div>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    let valid = true;
    const id  = document.getElementById('identifier');
    const pw  = document.getElementById('password');

    document.getElementById('identifierError').textContent = '';
    document.getElementById('passwordError').textContent   = '';

    if (!id.value.trim()) {
        document.getElementById('identifierError').textContent = 'Please enter your email or username.';
        valid = false;
    }
    if (!pw.value) {
        document.getElementById('passwordError').textContent = 'Please enter your password.';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
</body>
</html>
