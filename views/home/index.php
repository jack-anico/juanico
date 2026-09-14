<?php
$pageTitle = 'JUANICO – Premium Construction Materials';
$activeNav = 'home';
$extraCss  = [url('/assets/css/cart.css')];
require VIEW_PATH . '/partials/header.php';
?>

<!-- Hero -->
<section class="hero-section" id="home">
    <div class="container" style="max-width:1400px;margin:0 auto;padding:0 5%;">
        <div class="hero-content">
            <span class="hero-tag">New Collection 2026</span>
            <h1>Build With The Best Quality Materials</h1>
            <p>From foundations to finishing touches, Juanico provides industry-leading construction supplies trusted by top professionals across the nation.</p>
            <div class="hero-buttons">
                <a href="<?= url('/products') ?>" class="btn-primary" style="padding:0.85rem 2rem;">Shop Materials</a>
                <a href="#about" class="btn-secondary" style="padding:0.85rem 2rem;">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="stats-bar">
    <div class="stat-item"><h2>15k+</h2><p>Products in Stock</p></div>
    <div class="stat-item"><h2>98%</h2><p>On-Time Delivery</p></div>
    <div class="stat-item"><h2>24/7</h2><p>Expert Support</p></div>
    <div class="stat-item"><h2>50+</h2><p>Partner Brands</p></div>
</div>

<!-- Featured Categories -->
<section class="catalog-section" id="products">
    <div class="section-header">
        <span class="eyebrow">Featured Collection</span>
        <h2>Most Popular Supplies</h2>
        <p>Discover our top-selling construction materials, handpicked for exceptional durability and value.</p>
    </div>
    <div class="catalog-grid">
        <div class="catalog-card">
            <h4>🧱 Cement &amp; Aggregates</h4>
            <p>Premium grade cement, sand, and gravel for strong foundations and structural work.</p>
        </div>
        <div class="catalog-card">
            <h4>🔩 Steel &amp; Metals</h4>
            <p>High-tensile rebar, structural steel beams, and weatherproof roofing materials.</p>
        </div>
        <div class="catalog-card">
            <h4>🪵 Lumber &amp; Wood</h4>
            <p>Treated plywood, hardwoods, and precision framing lumber for every build.</p>
        </div>
        <div class="catalog-card">
            <h4>🔧 Tools &amp; Hardware</h4>
            <p>Professional grade power tools, fasteners, and certified safety equipment.</p>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="<?= url('/products') ?>" class="btn-primary" style="padding:0.85rem 2rem;">View Full Catalog &rarr;</a>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-section" id="about">
    <div class="inner">
        <span class="eyebrow">Why Juanico</span>
        <h2>We Deliver Excellence Every Time</h2>
        <p>We understand that in construction, time and quality are everything. That's why we've built a supply chain you can always depend on.</p>
        <ul class="features-list">
            <li>Same-day dispatch on in-stock items</li>
            <li>Wholesale pricing for bulk orders</li>
            <li>Certified quality control on all materials</li>
            <li>Dedicated account managers</li>
        </ul>
        <a href="<?= url('/products') ?>" class="btn-primary" style="padding:0.85rem 2rem;">Start Shopping</a>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section">
    <div class="section-header">
        <h3>Testimonials</h3>
        <h2>What Builders Are Saying</h2>
    </div>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="stars">★★★★★</div>
            <p>"Juanico has completely transformed our procurement. Their steel quality is unmatched, and deliveries are always exactly on schedule."</p>
            <div class="client-info">
                <div class="avatar"></div>
                <div><h5>Robert Chen</h5><span>Lead Engineer, BuildCo</span></div>
            </div>
        </div>
        <div class="testimonial-card">
            <div class="stars">★★★★★</div>
            <p>"Best supplier we've worked with in 15 years. Their bulk pricing helped us stay under budget for our latest high-rise project."</p>
            <div class="client-info">
                <div class="avatar"></div>
                <div><h5>Maria Rodriguez</h5><span>Procurement Manager</span></div>
            </div>
        </div>
        <div class="testimonial-card">
            <div class="stars">★★★★★</div>
            <p>"Exceptional customer service. When we had a last-minute spec change, their team worked the weekend to get us the right materials."</p>
            <div class="client-info">
                <div class="avatar"></div>
                <div><h5>David Smith</h5><span>Independent Contractor</span></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-banner" id="contact">
    <h2>Ready to start building?</h2>
    <p>Create an account today to access wholesale pricing and instant quotes.</p>
    <?php if (!isAuthenticated()): ?>
        <a href="<?= url('/register') ?>" class="cta-btn">Create Free Account</a>
    <?php else: ?>
        <a href="<?= url('/products') ?>" class="cta-btn">Shop Now</a>
    <?php endif; ?>
</section>

<?php
$cartProducts = [];
require VIEW_PATH . '/products/_cart.php';
require VIEW_PATH . '/partials/footer.php';
?>
