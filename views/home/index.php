<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juanico - Trusted Construction Supplier</title>
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
                <?php endif; ?>
                <a href="#cart" id="open-cart-btn" class="btn-shop">CART</a>
            </div>
        </div>
    </header>

    <section class="hero-section" id="home">
        <div class="hero-content">
            <span class="hero-tag">TRUSTED CONSTRUCTION SUPPLIER</span>
            <h1>QUALITY MATERIALS<br>FOR EVERY BUILD</h1>
            <p>From lumber to hardware, we supply everything contractors and DIY builders need in stock, ready for pickup or delivery.</p>
            <div class="hero-buttons">
                <a href="<?= url('/products') ?>" class="btn-primary">SHOP PRODUCTS</a>
                <a href="#about" class="btn-secondary">LEARN MORE</a>
            </div>
        </div>
    </section>

    <section class="stats-bar">
        <div class="stat-item">
            <h2>15+</h2>
            <p>Years of Experience</p>
        </div>
        <div class="stat-item">
            <h2>1,200+</h2>
            <p>Projects Supplied</p>
        </div>
        <div class="stat-item">
            <h2>50+</h2>
            <p>Product Categories</p>
        </div>
        <div class="stat-item">
            <h2>24/7</h2>
            <p>Delivery Support</p>
        </div>
    </section>

    <section class="catalog-section" id="categories">
        <div class="section-header">
            <h3>OUR CATALOG</h3>
            <h2>Everything For Your Build</h2>
            <p>Browse our full range of construction supplies, organized to help you find what you need</p>
        </div>
        <div class="catalog-grid">
            <div class="catalog-card">
                <h4>Lumber & Materials</h4>
                <p>Plywood, drywall, framing</p>
            </div>
            <div class="catalog-card">
                <h4>Tools & Equipment</h4>
                <p>Power tools, hand tools, machinery</p>
            </div>
            <div class="catalog-card">
                <h4>Safety & PPE</h4>
                <p>Helmets, vests, gloves</p>
            </div>
            <div class="catalog-card">
                <h4>Plumbing & Electrical</h4>
                <p>Pipes, wiring, fixtures</p>
            </div>
            <div class="catalog-card">
                <h4>Concrete & Masonry</h4>
                <p>Cement, blocks, mortar</p>
            </div>
            <div class="catalog-card">
                <h4>Hardware & Fasteners</h4>
                <p>Screws, nails, anchors</p>
            </div>
        </div>
    </section>

    <section class="why-choose-us" id="about">
        <div class="container">
            <span class="sub-title">WHY CHOOSE US</span>
            <h2>Built On Trust & Reliability</h2>
            <p>For over 15 years, contractors and homeowners across the region have counted on Juanico for quality materials, fair pricing, and a team that knows construction inside and out.</p>
            <ul class="features-list">
                <li>Licensed & Insured Supplier</li>
                <li>Same-Day Local Delivery</li>
                <li>Bulk & Contractor Pricing Available</li>
                <li>Expert Staff Support On-Site</li>
            </ul>
        </div>
    </section>

    <section class="testimonials-section">
        <div class="section-header">
            <span>TESTIMONIALS</span>
            <h2>What Our Clients Say</h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Juanico has been our go-to supplier for every project. Fast delivery and the staff always knows exactly what we need."</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>Marco Delgado</h5>
                        <span>Delgado Builders</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Great prices on bulk materials and the quality is always consistent. My crew trusts them on every job site."</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>Angela Ruiz</h5>
                        <span>Ruiz Contracting</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"As a first-time DIYer, the team walked me through exactly what I needed. Made my whole renovation so much easier!"</p>
                <div class="client-info">
                    <div class="avatar"></div>
                    <div>
                        <h5>Tomas Reyes</h5>
                        <span>Homeowner</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-banner" id="contact">
        <div class="container">
            <h2>Ready To Start Your Next Project?</h2>
            <p>Visit a branch, call our team, or request a quote online today</p>
            <a href="<?= url('/products') ?>" class="btn-primary">START SHOPPING</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>JUANICO</h3>
                <p>Quality construction materials and tools for every build.</p>
            </div>
            <div class="footer-col">
                <h4>PRODUCTS</h4>
                <ul>
                    <li><a href="#">Lumber & Materials</a></li>
                    <li><a href="#">Tools & Equipment</a></li>
                    <li><a href="#">Hardware & Fasteners</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>COMPANY</h4>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>VISIT US</h4>
                <p>1248 Industrial Pkwy<br>Riverside, CA 92501</p>
                <p>+1 951-123-4567</p>
                <p>info@juanico.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Juanico. All rights reserved.</p>
        </div>
    </footer>

    <?php include basePath('views/products/_cart.php'); ?>
    
</body>
</html>
