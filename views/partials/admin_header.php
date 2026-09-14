<?php
/**
 * Shared admin sidebar/layout header partial.
 * $adminTitle  – Page heading (required)
 * $adminActive – Active sidebar item: 'dashboard' | 'products'
 */
$adminActive = $adminActive ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle ?? 'Admin') ?> – JUANICO Admin</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
</head>
<body>
<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="<?= url('/') ?>" class="admin-brand">JUAN<span>ICO</span></a>

        <div class="admin-nav-section">
            <p class="admin-nav-label">Main Menu</p>
            <ul class="admin-nav">
                <li>
                    <a href="<?= url('/admin/dashboard') ?>" class="<?= $adminActive === 'dashboard' ? 'active' : '' ?>">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= url('/admin/products') ?>" class="<?= $adminActive === 'products' ? 'active' : '' ?>">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        Products
                    </a>
                </li>
            </ul>
        </div>

        <div class="admin-sidebar-footer">
            <form action="<?= url('/logout') ?>" method="POST">
                <?= csrf_field() ?>
                <button type="submit" class="btn-secondary" style="width:100%;font-size:0.82rem;padding:0.55rem;">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
