<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juanico - Premium Construction Materials</title>
    <link rel="stylesheet" href="<?= url('/assets/css/STYLE.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/cart.css') ?>">
</head>
<body style="display:flex; flex-direction:column; min-height:100vh;">
    <!-- Global Navigation Header -->
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
            <div class="header-action" style="display:flex; gap:10px; align-items:center;">
                <?php if (isAuthenticated()): ?>
                    <form action="<?= url('/logout') ?>" method="POST" style="margin:0;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-shop" style="border:none; cursor:pointer;">LOGOUT</button>
                    </form>
                <?php else: ?>
                    <a href="<?= url('/login') ?>" class="btn-shop" style="background:transparent; color:#0f172a; border:1px solid #e2e8f0;">LOGIN</a>
                <?php endif; ?>
                <a href="#cart" id="open-cart-btn" class="btn-shop">CART (<span id="cart-count">0</span>)</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-content">
            <span class="hero-tag">New Collection 2026</span>
            <h1>Build With The Best Quality Materials</h1>
            <p>From foundations to finishing touches, Juanico provides industry-leading construction supplies trusted by top professionals across the nation.</p>
            <div class="hero-buttons">
                <a href="<?= url('/products') ?>" class="btn-primary">Shop Materials</a>
                <a href="#about" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Quick Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <h2>15k+</h2>
            <p>Products in Stock</p>
        </div>
        <div class="stat-item">
            <h2>98%</h2>
            <p>On-Time Delivery</p>
        </div>
        <div class="stat-item">
            <h2>24/7</h2>
            <p>Expert Support</p>
        </div>
        <div class="stat-item">
            <h2>50+</h2>
            <p>Partner Brands</p>
        </div>
    </div>

    <!-- Featured Categories / Products Preview -->
    <section class="catalog-section" id="products">
        <div class="section-header">
            <h3>Featured Collection</h3>
            <h2>Most Popular Supplies</h2>
            <p>Discover our top-selling construction materials, handpicked for exceptional durability and value.</p>
        </div>
        
        <div class="catalog-grid">
            <div class="catalog-card">
                <h4>Cement & Aggregates</h4>
                <p>Premium grade cement, sand, and gravel for strong foundations.</p>
            </div>
            <div class="catalog-card">
                <h4>Steel & Metals</h4>
                <p>High-tensile rebar, structural steel, and roofing materials.</p>
            </div>
            <div class="catalog-card">
                <h4>Lumber & Wood</h4>
                <p>Treated plywood, hardwoods, and framing lumber.</p>
            </div>
            <div class="catalog-card">
                <h4>Tools & Hardware</h4>
                <p>Professional grade power tools, fasteners, and safety gear.</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 4rem;">
            <a href="<?= url('/products') ?>" class="btn-primary">View Full Catalog &rarr;</a>
        </div>
    </section>

    <!-- Why Choose Us / About -->
    <section class="why-choose-us" id="about">
        <div class="container">
            <span class="sub-title">WHY JUANICO</span>
            <h2>We Deliver Excellence Every Time</h2>
            <p>We understand that in construction, time and quality are everything. That's why we've built a supply chain you can depend on, day in and day out.</p>
            
            <ul class="features-list">
                <li>Same-day dispatch on in-stock items</li>
                <li>Wholesale pricing for bulk orders</li>
                <li>Certified quality control on all materials</li>
                <li>Dedicated account managers</li>
            </ul>
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
                <p>"Juanico has completely transformed our procurement process. Their steel quality is unmatched, and deliveries are always exactly on schedule."</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>Robert Chen</h5>
                        <span>Lead Engineer, BuildCo</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"The best supplier we've worked with in 15 years. Their bulk pricing on cement and aggregates helped us stay under budget for our latest high-rise."</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>Maria Rodriguez</h5>
                        <span>Procurement Manager</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Exceptional customer service. When we had a last-minute change in specs, their team worked over the weekend to get us the new materials."</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>David Smith</h5>
                        <span>Independent Contractor</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-banner" id="contact">
        <h2>Ready to start building?</h2>
        <p>Create an account today to access wholesale pricing and instant quotes.</p>
        <?php if (!isAuthenticated()): ?>
            <a href="<?= url('/register') ?>" class="btn-primary">Create Free Account</a>
        <?php else: ?>
            <a href="<?= url('/products') ?>" class="btn-primary">Shop Now</a>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h3 style="font-weight:800; font-size:1.5rem; letter-spacing:-0.5px; color:#fff;">JUANICO</h3>
                <p>Providing the highest quality construction materials for builders, contractors, and developers across the region.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="<?= url('/products') ?>">Products</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Categories</h4>
                <ul>
                    <li><a href="<?= url('/products') ?>">Steel & Rebar</a></li>
                    <li><a href="<?= url('/products') ?>">Cement & Aggregates</a></li>
                    <li><a href="<?= url('/products') ?>">Lumber</a></li>
                    <li><a href="<?= url('/products') ?>">Tools & Hardware</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li><a href="#">support@juanico.com</a></li>
                    <li><a href="#">+1 (555) 123-4567</a></li>
                    <li><a href="#">123 Builder Ave, Metro City</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Juanico Construction Supplies. All rights reserved.</p>
        </div>
    </footer>

    <?php
    $cartProducts = []; // Fetch or define if needed for homepage
    require __DIR__ . '/../products/_cart.php';
    ?>
</body>
</html>
