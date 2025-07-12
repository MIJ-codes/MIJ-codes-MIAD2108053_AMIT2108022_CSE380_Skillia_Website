<?php $currentPage = 'help-center'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Help Center</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/help-center.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="help-center-main">
    <!-- Hero Section -->
    <section class="help-hero-section help-anim-fade-up">
        <div class="help-hero-bg"></div>
        <div class="help-hero-content help-anim-zoom-in">
            <h1 class="help-hero-title help-anim-fade-up">Help <span>Center</span></h1>
            <p class="help-hero-subtitle help-anim-fade-up">Find answers to your questions and get the support you need.</p>
        </div>
    </section>

    <!-- Search Section -->
    <section class="help-search-section help-anim-fade-up">
        <div class="help-search-container">
            <div class="help-search-box help-anim-zoom-in">
                <i class="ri-search-line"></i>
                <input type="text" placeholder="Search for help articles, guides, and FAQs..." id="helpSearch">
                <button class="help-search-btn">
                    <i class="ri-arrow-right-line"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Quick Help Categories -->
    <section class="help-categories-section help-anim-fade-up">
        <div class="help-categories-container">
            <h2 class="help-categories-title help-anim-fade-up">Quick Help Categories</h2>
            <div class="help-categories-grid">
                <a href="#getting-started" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-rocket-line"></i>
                    </div>
                    <h3>Getting Started</h3>
                    <p>Learn the basics of using Skillia</p>
                </a>
                
                <a href="#account-management" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-user-settings-line"></i>
                    </div>
                    <h3>Account Management</h3>
                    <p>Manage your profile and settings</p>
                </a>
                
                <a href="#job-searching" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-search-line"></i>
                    </div>
                    <h3>Job Searching</h3>
                    <p>Find and apply to job opportunities</p>
                </a>
                
                <a href="#employer-tools" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-briefcase-line"></i>
                    </div>
                    <h3>Employer Tools</h3>
                    <p>Post jobs and manage candidates</p>
                </a>
                
                <a href="#technical-support" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-customer-service-line"></i>
                    </div>
                    <h3>Technical Support</h3>
                    <p>Resolve technical issues</p>
                </a>
                
                <a href="#billing-support" class="help-category-card help-anim-zoom-in">
                    <div class="help-category-icon">
                        <i class="ri-bank-card-line"></i>
                    </div>
                    <h3>Billing & Payments</h3>
                    <p>Manage subscriptions and payments</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Getting Started Section -->
    <section id="getting-started" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Getting Started</h2>
                <p class="help-content-subtitle help-anim-fade-up">New to Skillia? Start here to learn the basics.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I create an account?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Creating an account is simple! Click the "Sign Up" button in the top right corner of our homepage. You'll need to provide your email address, create a password, and fill in some basic information about yourself. Once you verify your email, you'll be ready to start your job search journey.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>What information should I include in my profile?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Your profile should include your current resume, work experience, education, skills, and any certifications. The more complete your profile is, the better employers can match you with relevant opportunities. Don't forget to add a professional photo and write a compelling summary about your career goals.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I search for jobs?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Use the search bar on the job board page to find opportunities by keyword, location, or company. You can also use filters to narrow down results by job type, experience level, salary range, and more. Save your search criteria to get notified when new matching jobs are posted.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Account Management Section -->
    <section id="account-management" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Account Management</h2>
                <p class="help-content-subtitle help-anim-fade-up">Learn how to manage your account settings and profile.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I update my profile information?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Go to your profile page and click the "Edit Profile" button. You can update your personal information, work experience, education, skills, and upload a new resume. Remember to save your changes when you're done.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I change my password?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Go to Account Settings and click on "Security." You can change your password there. Make sure to use a strong password with a mix of letters, numbers, and special characters for better security.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I delete my account?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>To delete your account, go to Account Settings and scroll down to "Delete Account." Please note that this action is permanent and will remove all your data from our platform. Make sure to download any important information before proceeding.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Searching Section -->
    <section id="job-searching" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Job Searching</h2>
                <p class="help-content-subtitle help-anim-fade-up">Tips and tricks for finding your dream job.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I apply for a job?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>When you find a job you're interested in, click the "Apply Now" button. You can use your saved resume or upload a new one. Some employers may ask for additional information or a cover letter. Make sure your application is complete before submitting.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I save job searches?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>After performing a search, click the "Save Search" button to save your search criteria. You'll receive email notifications when new jobs matching your criteria are posted. You can manage your saved searches in your account settings.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I track my applications?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Go to your dashboard and click on "My Applications" to see all the jobs you've applied for. You can track the status of each application and see if employers have viewed your profile or contacted you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Employer Tools Section -->
    <section id="employer-tools" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Employer Tools</h2>
                <p class="help-content-subtitle help-anim-fade-up">Learn how to use our tools for posting jobs and managing candidates.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I post a job?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Go to the "Post a Job" section and fill out the job posting form. Include a detailed job description, requirements, location, salary range, and any other relevant information. You can also set application deadlines and screening questions.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I manage applications?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>In your employer dashboard, go to "Job Applications" to see all applications for your posted jobs. You can review candidate profiles, download resumes, and contact applicants directly through our messaging system.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I search for candidates?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Use the candidate search feature to find potential hires by skills, experience, location, or other criteria. You can save candidate searches and receive notifications when new matching candidates join the platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technical Support Section -->
    <section id="technical-support" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Technical Support</h2>
                <p class="help-content-subtitle help-anim-fade-up">Get help with technical issues and platform problems.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>What browsers are supported?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>We support all modern browsers including Chrome, Firefox, Safari, and Edge. For the best experience, make sure your browser is updated to the latest version. We recommend using Chrome for optimal performance.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>I can't upload my resume. What should I do?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Make sure your file is in PDF, DOC, or DOCX format and is under 5MB. If you're still having issues, try clearing your browser cache or using a different browser. Contact our support team if the problem persists.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I reset my password?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Click on "Forgot Password" on the login page and enter your email address. We'll send you a link to reset your password. Make sure to check your spam folder if you don't receive the email within a few minutes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Billing Support Section -->
    <section id="billing-support" class="help-content-section help-anim-fade-up">
        <div class="help-content-container">
            <div class="help-content-header">
                <h2 class="help-content-title help-anim-fade-up">Billing & Payments</h2>
                <p class="help-content-subtitle help-anim-fade-up">Get help with billing, payments, and subscription management.</p>
            </div>
            
            <div class="help-faq-grid">
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>What payment methods do you accept?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for annual plans. All payments are processed securely through our payment partners.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>How do I cancel my subscription?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>Go to your account settings and click on "Billing & Subscription." You can cancel your subscription at any time. Your access will continue until the end of your current billing period.</p>
                    </div>
                </div>
                
                <div class="help-faq-item help-anim-zoom-in">
                    <div class="help-faq-question">
                        <h3>Can I get a refund?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="help-faq-answer">
                        <p>We offer a 30-day money-back guarantee for new subscriptions. If you're not satisfied with our service, contact our support team within 30 days of your first payment for a full refund.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support Section -->
    <section class="help-contact-section help-anim-fade-up">
        <div class="help-contact-container">
            <div class="help-contact-content help-anim-zoom-in">
                <h2 class="help-anim-fade-up">Still Need Help?</h2>
                <p class="help-anim-fade-up">Can't find what you're looking for? Our support team is here to help you.</p>
                <div class="help-contact-buttons">
                    <a href="contact-us.php" class="help-btn help-btn-primary help-anim-fade-left">Contact Support</a>
                    <a href="#" class="help-btn help-btn-secondary help-anim-fade-right">Live Chat</a>
                </div>
            </div>
            <div class="help-contact-visual">
                <div class="help-floating-shapes">
                    <div class="help-shape help-shape1"></div>
                    <div class="help-shape help-shape2"></div>
                    <div class="help-shape help-shape3"></div>
                    <div class="help-shape help-shape4"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/help-center.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 