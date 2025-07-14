<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Company</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/company.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="company-main">
    <!-- Hero Section -->
    <section class="company-hero-section">
        <div class="company-hero-content">
            <h1 class="company-hero-title">Company Information</h1>
            <p class="company-hero-subtitle">Learn more about Skillia and get the support you need.</p>
        </div>
    </section>
    <!-- Cards Section -->
    <section class="company-cards-section">
        <h2 class="company-cards-title">Company</h2>
        <div class="company-cards-grid">
            <div class="company-card-wrapper">
                <a href="about-us.php" class="company-card">
                    <div class="company-card-icon"><i class="ri-information-line"></i></div>
                    <div class="company-card-title">About Us</div>
                    <div class="company-card-desc">Discover our mission, vision, and the team behind Skillia.</div>
                </a>
            </div>
            <div class="company-card-wrapper">
                <a href="contact-us.php" class="company-card">
                    <div class="company-card-icon"><i class="ri-contacts-line"></i></div>
                    <div class="company-card-title">Contact Us</div>
                    <div class="company-card-desc">Get in touch with our support and business teams.</div>
                </a>
            </div>
            <div class="company-card-wrapper">
                <a href="privacy-policy.php" class="company-card">
                    <div class="company-card-icon"><i class="ri-shield-user-line"></i></div>
                    <div class="company-card-title">Privacy Policy</div>
                    <div class="company-card-desc">Read about how we protect your data and privacy.</div>
                </a>
            </div>
            <div class="company-card-wrapper">
                <a href="terms-of-service.php" class="company-card">
                    <div class="company-card-icon"><i class="ri-file-list-3-line"></i></div>
                    <div class="company-card-title">Terms of Service</div>
                    <div class="company-card-desc">Understand the rules and guidelines for using Skillia.</div>
                </a>
            </div>
            <div class="company-card-wrapper">
                <a href="help-center.php" class="company-card">
                    <div class="company-card-icon"><i class="ri-question-answer-line"></i></div>
                    <div class="company-card-title">Help Center</div>
                    <div class="company-card-desc">Find answers to common questions and get support.</div>
                </a>
            </div>
        </div>
    </section>
</div>
<script src="../assets/js/main.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 