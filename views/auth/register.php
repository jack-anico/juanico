<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body>
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
                        <nav class="main-nav">
                <ul>
                    <li><a href="<?= url('/#home') ?>">HOME</a></li>
                    <li><a href="<?= url('/products') ?>">PRODUCTS</a></li>
                    <li><a href="<?= url('/#services') ?>">SERVICES</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#projects') ?>">PROJECTS</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="form-card">
        <h2>Create an Account</h2>
        
        <?php if ($generalError = errors('general')): ?>
            <div class="alert-error">
                <?= e($generalError) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($csrfError = errors('csrf')): ?>
            <div class="alert-error">
                <?= e($csrfError) ?>
            </div>
        <?php endif; ?>

        <form action="<?= url('/register') ?>" method="POST" id="registerForm" novalidate>
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input" value="<?= old('username') ?>" required>
                <?php if (hasError('username')): ?>
                    <span class="form-error"><?= e(errors('username')) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" value="<?= old('email') ?>" required>
                <?php if (hasError('email')): ?>
                    <span class="form-error"><?= e(errors('email')) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number (Optional)</label>
                <input type="text" id="phone" name="phone" class="form-input" value="<?= old('phone') ?>">
                <?php if (hasError('phone')): ?>
                    <span class="form-error"><?= e(errors('phone')) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                <?php if (hasError('password')): ?>
                    <span class="form-error"><?= e(errors('password')) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                <?php if (hasError('password_confirmation')): ?>
                    <span class="form-error"><?= e(errors('password_confirmation')) ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-primary mt-3">REGISTER</button>
        </form>
        
        <p class="text-center mt-3">Already have an account? <a href="<?= url('/login') ?>" style="color:#ff6b00; font-weight:600; text-decoration:none;">Login here</a></p>
    </div>

    <!-- Client-side validation -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');
            
            document.querySelectorAll('.client-error').forEach(el => el.remove());

            if (!username.value.trim()) {
                isValid = false;
                showError(username, "Username is required");
            }
            if (!email.value.trim()) {
                isValid = false;
                showError(email, "Email is required");
            } else if (!/^\S+@\S+\.\S+$/.test(email.value)) {
                isValid = false;
                showError(email, "Please enter a valid email address");
            }
            if (!password.value.trim()) {
                isValid = false;
                showError(password, "Password is required");
            } else if (password.value.length < 8) {
                isValid = false;
                showError(password, "Password must be at least 8 characters");
            }
            if (password.value !== passwordConfirm.value) {
                isValid = false;
                showError(passwordConfirm, "Passwords do not match");
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(input, message) {
            const error = document.createElement('span');
            error.className = 'form-error client-error';
            error.innerText = message;
            input.parentNode.appendChild(error);
        }
    </script>
</body>
</html>
