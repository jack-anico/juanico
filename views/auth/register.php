<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh; background:#f8fafc;">
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
                        <button type="button" class="hamburger-btn" aria-label="Toggle navigation" onclick="document.querySelector('.main-nav').classList.toggle('nav-open')">&#9776;</button>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= url('/#home') ?>">HOME</a></li>
                    <li><a href="<?= url('/products') ?>">PRODUCTS</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
            <div class="header-action">
                <a href="<?= url('/login') ?>" class="btn-shop" style="background:transparent; color:#0f172a; border:1px solid #e2e8f0;">LOGIN</a>
            </div>
        </div>
    </header>

    <main style="flex:1; padding: 2rem 5%; display:flex; align-items:center; justify-content:center;">
        <div class="form-card" style="width:100%; margin: 2rem auto;">
            <h2>Create Account</h2>
            
            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error" role="alert"><?= e($generalError) ?></div>
            <?php endif; ?>

            <form action="<?= url('/register') ?>" method="POST" id="registerForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="username">Full Name</label>
                    <input type="text" id="username" name="username" class="form-input" value="<?= old('username') ?>" required autocomplete="name" autofocus>
                    <span class="form-error" id="usernameError">
                        <?php if (hasError('username')) echo e(errors('username')); ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-input" value="<?= old('email') ?>" required autocomplete="email">
                    <span class="form-error" id="emailError">
                        <?php if (hasError('email')) echo e(errors('email')); ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="<?= old('phone') ?>" autocomplete="tel">
                    <span class="form-error" id="phoneError">
                        <?php if (hasError('phone')) echo e(errors('phone')); ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password">
                    <span class="form-error" id="passwordError">
                        <?php if (hasError('password')) echo e(errors('password')); ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-input" required autocomplete="new-password">
                    <span class="form-error" id="passwordConfirmError">
                        <?php if (hasError('password_confirm')) echo e(errors('password_confirm')); ?>
                    </span>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn-primary" style="padding:1rem; font-size:1.05rem;">Register Now</button>
                </div>
                
                <div class="text-center mt-3">
                    <p style="color:#64748b; font-size:0.9rem;">Already have an account? <a href="<?= url('/login') ?>" style="color:#f97316; font-weight:600; text-decoration:none;">Sign in</a></p>
                </div>
            </form>
        </div>
    </main>
    
    <footer class="site-footer">
        <div class="footer-bottom" style="padding-top:1rem; border-top:none;">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>

    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        let hasError = false;
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;

        document.getElementById('usernameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('passwordConfirmError').textContent = '';

        if (!username) {
            document.getElementById('usernameError').textContent = 'Name is required.';
            hasError = true;
        }

        if (!email) {
            document.getElementById('emailError').textContent = 'Email is required.';
            hasError = true;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            hasError = true;
        }

        if (!password) {
            document.getElementById('passwordError').textContent = 'Password is required.';
            hasError = true;
        } else if (password.length < 8) {
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters.';
            hasError = true;
        }

        if (password !== passwordConfirm) {
            document.getElementById('passwordConfirmError').textContent = 'Passwords do not match.';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
    </script>
</body>
</html>
