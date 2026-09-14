<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account – JUANICO</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;">

<main class="auth-page">
    <div class="form-card">
        <div class="form-card-header">
            <a href="<?= url('/') ?>" class="brand-mark">JUAN<span>I</span>CO</a>
            <h1>Create your account</h1>
            <p>Join thousands of builders and contractors</p>
        </div>

        <?php if ($generalError = errors('general')): ?>
            <div class="alert alert-error" role="alert"><?= e($generalError) ?></div>
        <?php endif; ?>

        <form action="<?= url('/register') ?>" method="POST" id="registerForm" novalidate>
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" class="form-input"
                       value="<?= old('username') ?>" required autocomplete="name" autofocus placeholder="Juan dela Cruz">
                <span class="form-error" id="usernameError">
                    <?php if (hasError('username')) echo e(errors('username')); ?>
                </span>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input"
                       value="<?= old('email') ?>" required autocomplete="email" placeholder="you@example.com">
                <span class="form-error" id="emailError">
                    <?php if (hasError('email')) echo e(errors('email')); ?>
                </span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                <input type="tel" id="phone" name="phone" class="form-input"
                       value="<?= old('phone') ?>" autocomplete="tel" placeholder="+63 9XX XXX XXXX">
                <span class="form-error" id="phoneError">
                    <?php if (hasError('phone')) echo e(errors('phone')); ?>
                </span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input"
                       required autocomplete="new-password" placeholder="Min. 8 characters">
                <span class="form-error" id="passwordError">
                    <?php if (hasError('password')) echo e(errors('password')); ?>
                </span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                       required autocomplete="new-password" placeholder="Repeat password">
                <span class="form-error" id="passwordConfirmError">
                    <?php if (hasError('password_confirmation')) echo e(errors('password_confirmation')); ?>
                </span>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn-primary" style="width:100%;padding:0.85rem;font-size:1rem;">Create Account</button>
            </div>
        </form>

        <div class="form-footer mt-2">
            Already have an account? <a href="<?= url('/login') ?>">Sign in</a>
        </div>
    </div>
</main>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let valid = true;
    const fields = ['username','email','password','passwordConfirm'];
    fields.forEach(f => document.getElementById(f + 'Error') && (document.getElementById(f + 'Error').textContent = ''));

    const name = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const pw  = document.getElementById('password').value;
    const pw2 = document.getElementById('password_confirmation').value;

    if (!name) { document.getElementById('usernameError').textContent = 'Full name is required.'; valid = false; }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById('emailError').textContent = 'A valid email is required.'; valid = false; }
    if (pw.length < 8) { document.getElementById('passwordError').textContent = 'Password must be at least 8 characters.'; valid = false; }
    if (pw !== pw2)    { document.getElementById('passwordConfirmError').textContent = 'Passwords do not match.'; valid = false; }

    if (!valid) e.preventDefault();
});
</script>
</body>
</html>
