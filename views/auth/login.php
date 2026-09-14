<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juanico</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh; background:#f8fafc;">
    <header class="site-header">
        <div class="top-bar">
            <a href="<?= url('/') ?>" class="logo" style="text-decoration:none;">JUANICO</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= url('/#home') ?>">HOME</a></li>
                    <li><a href="<?= url('/products') ?>">PRODUCTS</a></li>
                    <li><a href="<?= url('/#about') ?>">ABOUT</a></li>
                    <li><a href="<?= url('/#contact') ?>">CONTACT</a></li>
                </ul>
            </nav>
            <div class="header-action">
                <a href="<?= url('/register') ?>" class="btn-shop" style="background:transparent; color:#0f172a; border:1px solid #e2e8f0;">REGISTER</a>
            </div>
        </div>
    </header>

    <main style="flex:1; padding: 2rem 5%; display:flex; align-items:center; justify-content:center;">
        <div class="form-card" style="width:100%; margin: 2rem auto;">
            <h2>Welcome Back</h2>
            
            <?php if ($generalError = errors('general')): ?>
                <div class="alert-error" role="alert"><?= e($generalError) ?></div>
            <?php endif; ?>

            <form action="<?= url('/login') ?>" method="POST" id="loginForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-input" value="<?= old('email') ?>" required autocomplete="email" autofocus>
                    <span class="form-error" id="emailError">
                        <?php if (hasError('email')) echo e(errors('email')); ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                    <span class="form-error" id="passwordError">
                        <?php if (hasError('password')) echo e(errors('password')); ?>
                    </span>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn-primary" style="padding:1rem; font-size:1.05rem;">Sign In</button>
                </div>
                
                <div class="text-center mt-3">
                    <p style="color:#64748b; font-size:0.9rem;">Don't have an account? <a href="<?= url('/register') ?>" style="color:#f97316; font-weight:600; text-decoration:none;">Register here</a></p>
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
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        let hasError = false;
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';

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
        }

        if (hasError) {
            e.preventDefault();
        }
    });
    </script>
</body>
</html>
