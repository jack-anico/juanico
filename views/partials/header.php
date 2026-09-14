<?php
/**
 * Shared public site header partial.
 *
 * Variables consumed:
 *   $pageTitle  – Browser tab title (required, include " - JUANICO" suffix yourself)
 *   $extraCss   – Array of additional CSS file URLs to load
 *   $activeNav  – Active nav item: 'home' | 'products' | 'about' | 'contact'
 */
$extraCss  = $extraCss ?? [];
$activeNav = $activeNav ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'JUANICO') ?></title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <?php foreach ($extraCss as $css): ?>
        <link rel="stylesheet" href="<?= e($css) ?>">
    <?php endforeach; ?>
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;">
<header class="site-header">
    <div class="top-bar">
        <a href="<?= url('/') ?>" class="logo">JUANICO</a>

        <button type="button" class="hamburger-btn" id="hamburger-btn" aria-label="Toggle navigation" aria-expanded="false">&#9776;</button>

        <nav class="main-nav" id="main-nav">
            <ul>
                <li><a href="<?= url('/#home') ?>"     class="<?= $activeNav === 'home'     ? 'active' : '' ?>">HOME</a></li>
                <li><a href="<?= url('/products') ?>"  class="<?= $activeNav === 'products' ? 'active' : '' ?>">PRODUCTS</a></li>
                <li><a href="<?= url('/#about') ?>"    class="<?= $activeNav === 'about'    ? 'active' : '' ?>">ABOUT</a></li>
                <li><a href="<?= url('/#contact') ?>"  class="<?= $activeNav === 'contact'  ? 'active' : '' ?>">CONTACT</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <?php if (isAuthenticated()): ?>
                <a href="<?= url('/orders') ?>" class="btn-ghost">My Orders</a>
                <form action="<?= url('/logout') ?>" method="POST" style="margin:0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-secondary" style="padding:0.5rem 1rem; font-size:0.82rem;">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?= url('/login') ?>"    class="btn-ghost">Login</a>
                <a href="<?= url('/register') ?>" class="btn-primary" style="padding:0.5rem 1rem; font-size:0.82rem;">Register</a>
            <?php endif; ?>
            <button type="button" id="open-cart-btn" class="btn-nav" style="gap:0.4rem;">
                🛒 <span id="cart-count">0</span>
            </button>
        </div>
    </div>
</header>
<script>
(function(){
    const btn = document.getElementById('hamburger-btn');
    const nav = document.getElementById('main-nav');
    if (!btn || !nav) return;
    btn.addEventListener('click', function() {
        const open = nav.classList.toggle('nav-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        btn.textContent = open ? '✕' : '☰';
    });
    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!btn.contains(e.target) && !nav.contains(e.target)) {
            nav.classList.remove('nav-open');
            btn.setAttribute('aria-expanded', 'false');
            btn.textContent = '☰';
        }
    });
})();
</script>
