<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Solutions - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/recruitment-solutions.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="recruitment-solutions-main">
    <section class="recruitment-solutions-hero-section">
        <div class="recruitment-solutions-hero-bg">
            <!-- Connection network lines -->
            <div class="connection-line-1"></div>
            <div class="connection-line-2"></div>
            <div class="connection-line-3"></div>
            
            <!-- Business icons -->
            <div class="business-icon-1"></div>
            <div class="business-icon-2"></div>
            <div class="business-icon-3"></div>
            
            <!-- Floating professional icons -->
            <span class="professional-icon-1"><i class="ri-building-line"></i></span>
            <span class="professional-icon-2"><i class="ri-team-line"></i></span>
            <span class="professional-icon-3"><i class="ri-handshake-line"></i></span>
        </div>
        <div class="recruitment-solutions-hero-content">
            <h1>Recruitment <span>Solutions</span></h1>
            <p>Explore our recruitment solutions designed to help you hire smarter and faster.</p>
        </div>
    </section>

    <!-- Recruitment Solutions Cards Section -->
    <section class="solutions-section">
        <div class="solutions-header">
            <h2>Our Recruitment Solutions</h2>
            <p>Skillia offers a range of modern, effective services to help you find and hire the best talent.</p>
        </div>
        <div class="solutions-cards">
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-robot-2-line"></i></div>
                <h3>AI-Powered Screening</h3>
                <p>Automatically filter and rank candidates using smart algorithms for faster shortlisting.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-video-chat-line"></i></div>
                <h3>Video Interviews</h3>
                <p>Conduct remote interviews with built-in scheduling, recording, and feedback tools.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-bar-chart-2-line"></i></div>
                <h3>Skills Assessment</h3>
                <p>Test technical and soft skills with customizable online assessments and quizzes.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-shield-user-line"></i></div>
                <h3>Background Verification</h3>
                <p>Verify candidate credentials, references, and work history for peace of mind.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-database-2-line"></i></div>
                <h3>Talent Pipeline</h3>
                <p>Access a curated database of pre-screened candidates ready for your roles.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon"><i class="ri-pie-chart-2-line"></i></div>
                <h3>Recruitment Analytics</h3>
                <p>Get actionable insights and reports to optimize your hiring process.</p>
            </div>
        </div>
        <div class="solutions-footer">
            <a href="contact-us.php" class="solutions-contact-btn"><i class="ri-mail-send-line"></i> Contact Us for Custom Solutions</a>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 