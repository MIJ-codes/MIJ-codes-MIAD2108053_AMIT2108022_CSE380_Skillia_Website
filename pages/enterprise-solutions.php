<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Solutions - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/enterprise-solutions.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="enterprise-solutions-main">
    <section class="enterprise-solutions-hero-section">
        <div class="enterprise-solutions-hero-bg">
            <!-- Corporate network nodes -->
            <div class="network-node-1"></div>
            <div class="network-node-2"></div>
            <div class="network-node-3"></div>
            
            <!-- Data flow connections -->
            <div class="data-flow-1"></div>
            <div class="data-flow-2"></div>
            <div class="data-flow-3"></div>
            
            <!-- Enterprise icons -->
            <span class="enterprise-icon-1"><i class="ri-building-2-line"></i></span>
            <span class="enterprise-icon-2"><i class="ri-global-line"></i></span>
            <span class="enterprise-icon-3"><i class="ri-shield-check-line"></i></span>
        </div>
        <div class="enterprise-solutions-hero-content">
            <h1>Enterprise <span>Solutions</span></h1>
            <p>Discover how Skillia can support your enterprise hiring and workforce needs.</p>
        </div>
    </section>

    <!-- Enterprise Solutions Cards Section -->
    <section class="enterprise-section">
        <div class="enterprise-header">
            <h2>Enterprise Services</h2>
            <p>Specialized solutions for large organizations, tailored to your unique hiring and workforce needs.</p>
        </div>
        <div class="enterprise-cards">
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-building-4-line"></i></div>
                <h3>Custom Job Portal</h3>
                <p>Get a white-label recruitment platform with your company’s branding and features.</p>
            </div>
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-group-line"></i></div>
                <h3>Bulk Hiring Campaigns</h3>
                <p>Run mass recruitment drives with advanced filtering, scheduling, and analytics.</p>
            </div>
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-exchange-dollar-line"></i></div>
                <h3>HR System Integration</h3>
                <p>Seamlessly connect Skillia with your existing HR and payroll systems via API.</p>
            </div>
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-user-star-line"></i></div>
                <h3>Dedicated Account Manager</h3>
                <p>Work with a personal consultant for tailored support and recruitment strategy.</p>
            </div>
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-palette-line"></i></div>
                <h3>Custom Branding</h3>
                <p>Showcase your company’s identity with custom design, logos, and messaging.</p>
            </div>
            <div class="enterprise-card">
                <div class="enterprise-icon-card"><i class="ri-bar-chart-grouped-line"></i></div>
                <h3>Advanced Analytics</h3>
                <p>Access detailed hiring reports, workforce insights, and performance metrics.</p>
            </div>
        </div>
        <div class="enterprise-footer">
            <a href="contact-us.php" class="enterprise-contact-btn"><i class="ri-mail-send-line"></i> Contact Us for Enterprise Solutions</a>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 