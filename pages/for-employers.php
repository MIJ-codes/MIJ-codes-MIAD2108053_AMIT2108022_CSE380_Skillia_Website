<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - For Employers</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/for-employers.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="employers-main">
    <!-- Hero Section -->
    <section class="employers-hero-section">
        <div class="employers-hero-content">
            <h1 class="employers-hero-title">Empower Your Hiring</h1>
            <p class="employers-hero-subtitle">Discover tools and solutions to find, attract, and hire top talent for your company.</p>
        </div>
    </section>
    <!-- Cards Section -->
    <section class="employers-cards-section">
        <h2 class="employers-cards-title">For Employers</h2>
        <div class="employers-cards-grid">
            <div class="employers-card-wrapper">
                <a href="post-job.php" class="employers-card">
                    <div class="employers-card-icon"><i class="ri-briefcase-4-line"></i></div>
                    <div class="employers-card-title">Post a Job</div>
                    <div class="employers-card-desc">Reach thousands of candidates by posting your job openings easily.</div>
                </a>
            </div>
            <div class="employers-card-wrapper">
                <a href="search-candidates.php" class="employers-card">
                    <div class="employers-card-icon"><i class="ri-search-line"></i></div>
                    <div class="employers-card-title">Search Candidates</div>
                    <div class="employers-card-desc">Browse and filter through a large pool of qualified job seekers.</div>
                </a>
            </div>
        </div>
        <!-- Why Choose Skillia Section -->
        <section class="employers-why-skillia">
            <h3>Why Choose Skillia?</h3>
            <div class="why-skillia-grid">
                <div class="why-skillia-item"><i class="ri-user-search-line"></i><span>Access a large, diverse talent pool</span></div>
                <div class="why-skillia-item"><i class="ri-flashlight-line"></i><span>Fast, targeted candidate matching</span></div>
                <div class="why-skillia-item"><i class="ri-dashboard-line"></i><span>Modern, easy-to-use dashboard</span></div>
                <div class="why-skillia-item"><i class="ri-shield-check-line"></i><span>Secure & confidential hiring</span></div>
                <div class="why-skillia-item"><i class="ri-customer-service-2-line"></i><span>Dedicated employer support</span></div>
            </div>
        </section>
        <!-- How It Works Section -->
        <section class="employers-how-it-works">
            <h3>How It Works</h3>
            <div class="how-it-works-steps">
                <div class="how-step"><span class="step-num">1</span><span>Post your job</span></div>
                <div class="how-step"><span class="step-num">2</span><span>Search & filter candidates</span></div>
                <div class="how-step"><span class="step-num">3</span><span>Shortlist & contact</span></div>
                <div class="how-step"><span class="step-num">4</span><span>Hire the best talent</span></div>
            </div>
        </section>
        <!-- Employer Testimonials Section -->
        <section class="employers-testimonials">
            <h3>What Employers Say</h3>
            <div class="testimonials-grid">
                <div class="testimonial-item">
                    <p>“Skillia helped us fill our open positions 2x faster than before. The candidate quality is excellent!”</p>
                    <span>- HR Manager, TechCorp</span>
                </div>
                <div class="testimonial-item">
                    <p>“The dashboard is intuitive and the support team is always responsive. Highly recommended!”</p>
                    <span>- Talent Lead, FinEdge</span>
                </div>
                <div class="testimonial-item">
                    <p>“We found specialized talent for a hard-to-fill role in days, not weeks. Great experience!”</p>
                    <span>- CEO, HealthPlus</span>
                </div>
            </div>
        </section>
        <!-- Call to Action -->
        <section class="employers-cta">
            <a href="post-job.php" class="employers-cta-btn">Post a Job Now</a>
            <a href="contact-us.php" class="employers-cta-link">Contact Employer Support</a>
        </section>
    </section>
</div>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/for-employers.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 