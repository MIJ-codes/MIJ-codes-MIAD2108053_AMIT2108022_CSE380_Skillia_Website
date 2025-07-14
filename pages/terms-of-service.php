<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php $currentPage = 'terms-of-service'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Terms of Service</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/terms-of-service.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="terms-of-service-main">
    <!-- Hero Section -->
    <section class="terms-hero-section terms-anim-fade-up">
        <div class="terms-hero-bg"></div>
        <div class="terms-hero-content terms-anim-zoom-in">
            <h1 class="terms-hero-title terms-anim-fade-up">Terms of <span>Service</span></h1>
            <p class="terms-hero-subtitle terms-anim-fade-up">Please read these terms carefully before using our platform.</p>
        </div>
    </section>

    <!-- Table of Contents -->
    <section class="terms-toc-section terms-anim-fade-up">
        <div class="terms-toc-container">
            <h2 class="terms-toc-title terms-anim-fade-up">Quick Navigation</h2>
            <div class="terms-toc-grid">
                <a href="#acceptance" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-check-line"></i>
                    <span>Acceptance of Terms</span>
                </a>
                <a href="#services" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-service-line"></i>
                    <span>Our Services</span>
                </a>
                <a href="#user-accounts" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-user-settings-line"></i>
                    <span>User Accounts</span>
                </a>
                <a href="#user-conduct" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-shield-check-line"></i>
                    <span>User Conduct</span>
                </a>
                <a href="#intellectual-property" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-copyright-line"></i>
                    <span>Intellectual Property</span>
                </a>
                <a href="#limitation-liability" class="terms-toc-card terms-anim-zoom-in">
                    <i class="ri-error-warning-line"></i>
                    <span>Limitation of Liability</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Acceptance of Terms Section -->
    <section id="acceptance" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">Acceptance of Terms</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">By accessing and using Skillia, you agree to be bound by these terms and conditions.</p>
            </div>
            
            <div class="terms-content-grid">
                <div class="terms-content-card terms-anim-zoom-in">
                    <div class="terms-card-icon">
                        <i class="ri-check-double-line"></i>
                    </div>
                    <h3>Agreement to Terms</h3>
                    <p>By using our platform, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you must not use our services.</p>
                </div>
                
                <div class="terms-content-card terms-anim-zoom-in">
                    <div class="terms-card-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <h3>Changes to Terms</h3>
                    <p>We reserve the right to modify these terms at any time. We will notify users of any material changes via email or through our platform. Continued use after changes constitutes acceptance of the new terms.</p>
                </div>
                
                <div class="terms-content-card terms-anim-zoom-in">
                    <div class="terms-card-icon">
                        <i class="ri-information-line"></i>
                    </div>
                    <h3>Contact Information</h3>
                    <p>If you have any questions about these terms, please contact us through our support channels. We're here to help clarify any concerns you may have.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Services Section -->
    <section id="services" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">Our Services</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">Skillia provides job matching and recruitment services for job seekers and employers.</p>
            </div>
            
            <div class="terms-services-grid">
                <div class="terms-service-item terms-anim-fade-left">
                    <div class="terms-service-icon">
                        <i class="ri-user-search-line"></i>
                    </div>
                    <div class="terms-service-content">
                        <h3>Job Search Platform</h3>
                        <p>We provide a platform where job seekers can search for opportunities, create profiles, and apply to positions posted by employers.</p>
                    </div>
                </div>
                
                <div class="terms-service-item terms-anim-fade-right">
                    <div class="terms-service-icon">
                        <i class="ri-briefcase-line"></i>
                    </div>
                    <div class="terms-service-content">
                        <h3>Employer Services</h3>
                        <p>Employers can post job openings, search for candidates, and manage their recruitment process through our platform.</p>
                    </div>
                </div>
                
                <div class="terms-service-item terms-anim-fade-left">
                    <div class="terms-service-icon">
                        <i class="ri-notification-line"></i>
                    </div>
                    <div class="terms-service-content">
                        <h3>Communication Tools</h3>
                        <p>We provide messaging and notification systems to facilitate communication between job seekers and employers.</p>
                    </div>
                </div>
                
                <div class="terms-service-item terms-anim-fade-right">
                    <div class="terms-service-icon">
                        <i class="ri-analytics-line"></i>
                    </div>
                    <div class="terms-service-content">
                        <h3>Analytics & Insights</h3>
                        <p>We offer analytics and insights to help users understand their job search or recruitment performance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Accounts Section -->
    <section id="user-accounts" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">User Accounts</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">Guidelines for creating and maintaining your account on our platform.</p>
            </div>
            
            <div class="terms-accounts-grid">
                <div class="terms-accounts-card terms-anim-zoom-in">
                    <div class="terms-accounts-icon">
                        <i class="ri-user-add-line"></i>
                    </div>
                    <h3>Account Creation</h3>
                    <p>You must provide accurate and complete information when creating your account. You are responsible for maintaining the security of your login credentials.</p>
                </div>
                
                <div class="terms-accounts-card terms-anim-zoom-in">
                    <div class="terms-accounts-icon">
                        <i class="ri-lock-password-line"></i>
                    </div>
                    <h3>Account Security</h3>
                    <p>You are responsible for all activities that occur under your account. Notify us immediately of any unauthorized use of your account.</p>
                </div>
                
                <div class="terms-accounts-card terms-anim-zoom-in">
                    <div class="terms-accounts-icon">
                        <i class="ri-delete-bin-line"></i>
                    </div>
                    <h3>Account Termination</h3>
                    <p>We reserve the right to terminate accounts that violate our terms or engage in fraudulent or harmful activities.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- User Conduct Section -->
    <section id="user-conduct" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">User Conduct</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">Guidelines for appropriate behavior and prohibited activities on our platform.</p>
            </div>
            
            <div class="terms-conduct-grid">
                <div class="terms-conduct-item terms-anim-zoom-in">
                    <div class="terms-conduct-icon">
                        <i class="ri-check-line"></i>
                    </div>
                    <h3>Permitted Activities</h3>
                    <ul>
                        <li>Creating accurate and truthful profiles</li>
                        <li>Applying to relevant job opportunities</li>
                        <li>Communicating professionally with other users</li>
                        <li>Providing honest feedback and reviews</li>
                    </ul>
                </div>
                
                <div class="terms-conduct-item terms-anim-zoom-in">
                    <div class="terms-conduct-icon">
                        <i class="ri-close-line"></i>
                    </div>
                    <h3>Prohibited Activities</h3>
                    <ul>
                        <li>Providing false or misleading information</li>
                        <li>Harassing or discriminating against other users</li>
                        <li>Spamming or sending unsolicited messages</li>
                        <li>Attempting to circumvent our security measures</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Intellectual Property Section -->
    <section id="intellectual-property" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">Intellectual Property</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">Information about ownership and use of content on our platform.</p>
            </div>
            
            <div class="terms-ip-grid">
                <div class="terms-ip-card terms-anim-zoom-in">
                    <div class="terms-ip-icon">
                        <i class="ri-copyright-line"></i>
                    </div>
                    <h3>Platform Ownership</h3>
                    <p>Skillia and its content, including but not limited to text, graphics, logos, and software, are owned by us and protected by copyright laws.</p>
                </div>
                
                <div class="terms-ip-card terms-anim-zoom-in">
                    <div class="terms-ip-icon">
                        <i class="ri-user-line"></i>
                    </div>
                    <h3>User Content</h3>
                    <p>You retain ownership of content you submit to our platform. By submitting content, you grant us a license to use it for platform purposes.</p>
                </div>
                
                <div class="terms-ip-card terms-anim-zoom-in">
                    <div class="terms-ip-icon">
                        <i class="ri-shield-line"></i>
                    </div>
                    <h3>Third-Party Content</h3>
                    <p>We respect intellectual property rights. If you believe your content has been used inappropriately, please contact us immediately.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Limitation of Liability Section -->
    <section id="limitation-liability" class="terms-content-section terms-anim-fade-up">
        <div class="terms-content-container">
            <div class="terms-content-header">
                <h2 class="terms-content-title terms-anim-fade-up">Limitation of Liability</h2>
                <p class="terms-content-subtitle terms-anim-fade-up">Important information about our liability and your responsibilities.</p>
            </div>
            
            <div class="terms-liability-grid">
                <div class="terms-liability-item terms-anim-zoom-in">
                    <div class="terms-liability-icon">
                        <i class="ri-error-warning-line"></i>
                    </div>
                    <h3>Service Availability</h3>
                    <p>We strive to maintain high service availability but cannot guarantee uninterrupted access. We are not liable for any damages resulting from service interruptions.</p>
                </div>
                
                <div class="terms-liability-item terms-anim-zoom-in">
                    <div class="terms-liability-icon">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <h3>Data Security</h3>
                    <p>While we implement security measures, we cannot guarantee complete protection against all threats. Users should take appropriate precautions with their data.</p>
                </div>
                
                <div class="terms-liability-item terms-anim-zoom-in">
                    <div class="terms-liability-icon">
                        <i class="ri-links-line"></i>
                    </div>
                    <h3>Third-Party Services</h3>
                    <p>We may integrate with third-party services. We are not responsible for the actions, content, or policies of these third parties.</p>
                </div>
                
                <div class="terms-liability-item terms-anim-zoom-in">
                    <div class="terms-liability-icon">
                        <i class="ri-scales-line"></i>
                    </div>
                    <h3>Maximum Liability</h3>
                    <p>Our total liability to you for any claims arising from these terms or your use of our services shall not exceed the amount you paid us in the past 12 months.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="terms-contact-section terms-anim-fade-up">
        <div class="terms-contact-container">
            <div class="terms-contact-content terms-anim-zoom-in">
                <h2 class="terms-anim-fade-up">Questions About Our Terms?</h2>
                <p class="terms-anim-fade-up">If you have any questions about these terms of service or need clarification on any section, please don't hesitate to reach out to us.</p>
                <div class="terms-contact-buttons">
                    <a href="contact-us.php" class="terms-btn terms-btn-primary terms-anim-fade-left">Contact Us</a>
                    <a href="privacy-policy.php" class="terms-btn terms-btn-secondary terms-anim-fade-right">Privacy Policy</a>
                </div>
            </div>
            <div class="terms-contact-visual">
                <div class="terms-floating-shapes">
                    <div class="terms-shape terms-shape1"></div>
                    <div class="terms-shape terms-shape2"></div>
                    <div class="terms-shape terms-shape3"></div>
                    <div class="terms-shape terms-shape4"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/terms-of-service.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 