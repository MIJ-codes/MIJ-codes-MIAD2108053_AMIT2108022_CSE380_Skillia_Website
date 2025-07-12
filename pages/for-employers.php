<?php $currentPage = 'for-employers'; ?>
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
            <div class="employers-card-wrapper">
                <a href="recruitment-solutions.php" class="employers-card">
                    <div class="employers-card-icon"><i class="ri-user-star-line"></i></div>
                    <div class="employers-card-title">Recruitment Solutions</div>
                    <div class="employers-card-desc">Get expert help and AI-powered tools for smarter hiring decisions.</div>
                </a>
            </div>
            <div class="employers-card-wrapper">
                <a href="pricing-plans.php" class="employers-card">
                    <div class="employers-card-icon"><i class="ri-money-dollar-circle-line"></i></div>
                    <div class="employers-card-title">Pricing Plans</div>
                    <div class="employers-card-desc">Choose the best plan for your hiring needs and budget.</div>
                </a>
            </div>
            <div class="employers-card-wrapper">
                <a href="enterprise-solutions.php" class="employers-card">
                    <div class="employers-card-icon"><i class="ri-building-4-line"></i></div>
                    <div class="employers-card-title">Enterprise Solutions</div>
                    <div class="employers-card-desc">Custom solutions for large organizations and bulk hiring.</div>
                </a>
            </div>
        </div>
    </section>
</div>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/for-employers.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 