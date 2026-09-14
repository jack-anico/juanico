<?php
/**
 * Shared site footer partial.
 */
?>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <h3>JUANICO</h3>
            <p>Providing the highest quality construction materials for builders, contractors, and developers across the region since 2010.</p>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="<?= url('/#home') ?>">Home</a></li>
                <li><a href="<?= url('/products') ?>">Products</a></li>
                <li><a href="<?= url('/#about') ?>">About Us</a></li>
                <li><a href="<?= url('/#contact') ?>">Contact</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Categories</h4>
            <ul>
                <li><a href="<?= url('/products') ?>">Steel &amp; Rebar</a></li>
                <li><a href="<?= url('/products') ?>">Cement &amp; Aggregates</a></li>
                <li><a href="<?= url('/products') ?>">Lumber</a></li>
                <li><a href="<?= url('/products') ?>">Tools &amp; Hardware</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <ul>
                <li><a href="mailto:support@juanico.ph">support@juanico.ph</a></li>
                <li><a href="tel:+63291234567">+63 (2) 9123-4567</a></li>
                <li><a href="#">123 Builder Ave, Metro City</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Juanico Construction Supplies. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
