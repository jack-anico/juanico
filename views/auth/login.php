<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juanico</title>
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
        <h2>Login to Your Account</h2>
        
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

        <form action="<?= url('/login') ?>" method="POST" id="loginForm" novalidate>
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="identifier">Email or Username</label>
                <input type="text" id="identifier" name="identifier" class="form-input" value="<?= old('identifier') ?>" required>
                <?php if (hasError('identifier')): ?>
                    <span class="form-error"><?= e(errors('identifier')) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                <?php if (hasError('password')): ?>
                    <span class="form-error"><?= e(errors('password')) ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-primary mt-3">LOGIN</button>
        </form>
        
        <p class="text-center mt-3">Don't have an account? <a href="<?= url('/register') ?>" style="color:#ff6b00; font-weight:600; text-decoration:none;">Register here</a></p>
    </div>

    <!-- Client-side validation -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let isValid = true;
            const identifier = document.getElementById('identifier');
            const password = document.getElementById('password');
            
            document.querySelectorAll('.client-error').forEach(el => el.remove());

            if (!identifier.value.trim()) {
                isValid = false;
                showError(identifier, "Email or Username is required");
            }
            if (!password.value.trim()) {
                isValid = false;
                showError(password, "Password is required");
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
