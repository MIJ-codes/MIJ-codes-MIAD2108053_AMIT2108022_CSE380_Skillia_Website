<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/pricing-plans.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="pricing-plans-main">
    <section class="pricing-plans-hero-section">
        <div class="pricing-plans-hero-bg">
            <!-- Price tag shapes -->
            <div class="price-tag-1"></div>
            <div class="price-tag-2"></div>
            
            <!-- Value indicator bars -->
            <div class="value-bar-1"></div>
            <div class="value-bar-2"></div>
            <div class="value-bar-3"></div>
            
            <!-- Floating pricing icons -->
            <span class="pricing-icon-1"><i class="ri-money-dollar-circle-line"></i></span>
            <span class="pricing-icon-2"><i class="ri-price-tag-3-line"></i></span>
            <span class="pricing-icon-3"><i class="ri-coins-line"></i></span>
        </div>
        <div class="pricing-plans-hero-content">
            <h1>Pricing <span>Plans</span></h1>
            <p>Choose the right plan for your hiring needs. Flexible options for every business size.</p>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="pricing-section">
        <div class="pricing-header">
            <h2>Our Pricing Plans</h2>
            <p>Simple, transparent pricing for every business. No hidden fees.</p>
        </div>
        <div class="pricing-cards">
            <div class="pricing-card">
                <div class="pricing-icon"><i class="ri-leaf-line"></i></div>
                <h3>Basic</h3>
                <div class="price">৳1,500<span>/month</span></div>
                <ul class="features-list">
                    <li><i class="ri-check-line"></i> 5 Job Posts</li>
                    <li><i class="ri-check-line"></i> Basic Candidate Search</li>
                    <li><i class="ri-check-line"></i> Email Support</li>
                    <li class="disabled"><i class="ri-close-line"></i> AI Screening</li>
                    <li class="disabled"><i class="ri-close-line"></i> Video Interviews</li>
                </ul>
                <button class="choose-plan-btn" disabled>Choose Plan</button>
            </div>
            <div class="pricing-card popular">
                <div class="pricing-icon"><i class="ri-star-smile-line"></i></div>
                <h3>Professional</h3>
                <div class="price">৳4,500<span>/month</span></div>
                <ul class="features-list">
                    <li><i class="ri-check-line"></i> 20 Job Posts</li>
                    <li><i class="ri-check-line"></i> Advanced Candidate Search</li>
                    <li><i class="ri-check-line"></i> AI Screening</li>
                    <li><i class="ri-check-line"></i> Video Interviews</li>
                    <li><i class="ri-check-line"></i> Priority Support</li>
                </ul>
                <button class="choose-plan-btn" disabled>Choose Plan</button>
                <div class="popular-badge">Most Popular</div>
            </div>
            <div class="pricing-card">
                <div class="pricing-icon"><i class="ri-building-4-line"></i></div>
                <h3>Enterprise</h3>
                <div class="price">Custom</div>
                <ul class="features-list">
                    <li><i class="ri-check-line"></i> Unlimited Job Posts</li>
                    <li><i class="ri-check-line"></i> All Professional Features</li>
                    <li><i class="ri-check-line"></i> Dedicated Account Manager</li>
                    <li><i class="ri-check-line"></i> Custom Integrations</li>
                    <li><i class="ri-check-line"></i> 24/7 Premium Support</li>
                </ul>
                <button class="choose-plan-btn" disabled>Contact Sales</button>
            </div>
        </div>
        <div class="pricing-footer">
            <a href="contact-us.php" class="pricing-contact-btn"><i class="ri-mail-send-line"></i> Contact Us for Custom Plans</a>
        </div>
    </section>

    <!-- Feature Comparison Table -->
    <section class="comparison-section">
        <div class="comparison-header">
            <h2>Compare Features</h2>
        </div>
        <div class="comparison-table-wrapper">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>Basic</th>
                        <th>Professional</th>
                        <th>Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Job Posts</td>
                        <td>5</td>
                        <td>20</td>
                        <td>Unlimited</td>
                    </tr>
                    <tr>
                        <td>Candidate Search</td>
                        <td>Basic</td>
                        <td>Advanced</td>
                        <td>Advanced</td>
                    </tr>
                    <tr>
                        <td>AI Screening</td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                    </tr>
                    <tr>
                        <td>Video Interviews</td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                    </tr>
                    <tr>
                        <td>Support</td>
                        <td>Email</td>
                        <td>Priority</td>
                        <td>24/7 Premium</td>
                    </tr>
                    <tr>
                        <td>Account Manager</td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                    </tr>
                    <tr>
                        <td>Custom Integrations</td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-close-line"></i></td>
                        <td><i class="ri-check-line"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 