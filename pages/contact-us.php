<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Contact Us</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/contact-us.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="contact-us-main">
    <!-- Hero Section -->
    <section class="contact-hero-section contact-anim-fade-up">
        <div class="contact-hero-bg"></div>
        <div class="contact-hero-content contact-anim-zoom-in">
            <h1 class="contact-hero-title contact-anim-fade-up">Get in <span>Touch</span></h1>
            <p class="contact-hero-subtitle contact-anim-fade-up">We'd love to hear from you. Let's start a conversation.</p>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section contact-anim-fade-up">
        <div class="contact-info-container">
            <h2 class="contact-info-title contact-anim-fade-up">Contact Information</h2>
            <div class="contact-info-grid">
                <div class="contact-info-card contact-anim-zoom-in">
                    <div class="contact-info-icon">
                        <i class="ri-map-pin-line"></i>
                    </div>
                    <h3 class="contact-anim-fade-up">Our Location</h3>
                    <p class="contact-anim-fade-up">123 Innovation Street<br>Tech District, Dhaka 1200<br>Bangladesh</p>
                </div>
                <div class="contact-info-card contact-anim-zoom-in">
                    <div class="contact-info-icon">
                        <i class="ri-phone-line"></i>
                    </div>
                    <h3 class="contact-anim-fade-up">Phone Number</h3>
                    <p class="contact-anim-fade-up">+880 1234-567890<br>+880 1234-567891</p>
                </div>
                <div class="contact-info-card contact-anim-zoom-in">
                    <div class="contact-info-icon">
                        <i class="ri-mail-line"></i>
                    </div>
                    <h3 class="contact-anim-fade-up">Email Address</h3>
                    <p class="contact-anim-fade-up">info@skillia.com<br>support@skillia.com</p>
                </div>
                <div class="contact-info-card contact-anim-zoom-in">
                    <div class="contact-info-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <h3 class="contact-anim-fade-up">Working Hours</h3>
                    <p class="contact-anim-fade-up">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section contact-anim-fade-up">
        <div class="contact-form-container">
            <div class="contact-form-content">
                <h2 class="contact-form-title contact-anim-fade-up">Send us a Message</h2>
                <p class="contact-form-subtitle contact-anim-fade-up">Fill out the form below and we'll get back to you as soon as possible.</p>
                
                <form class="contact-form contact-anim-zoom-in">
                    <div class="form-row">
                        <div class="form-group contact-anim-fade-left">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group contact-anim-fade-right">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group contact-anim-fade-left">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group contact-anim-fade-right">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-group contact-anim-fade-up">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="partnership">Partnership</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group contact-anim-fade-up">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <div class="form-group contact-anim-fade-up">
                        <button type="submit" class="contact-submit-btn">
                            <span>Send Message</span>
                            <i class="ri-send-plane-line"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="contact-form-visual">
                <div class="contact-visual-container contact-anim-zoom-in">
                    <div class="contact-floating-elements">
                        <div class="contact-element contact-element1"></div>
                        <div class="contact-element contact-element2"></div>
                        <div class="contact-element contact-element3"></div>
                        <div class="contact-element contact-element4"></div>
                    </div>
                    <div class="contact-illustration">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="contact-faq-section contact-anim-fade-up">
        <div class="contact-faq-container">
            <h2 class="contact-faq-title contact-anim-fade-up">Frequently Asked Questions</h2>
            <div class="contact-faq-grid">
                <div class="contact-faq-item contact-anim-zoom-in">
                    <div class="contact-faq-question">
                        <h3>How do I create an account?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>Creating an account is simple! Click the "Sign Up" button in the top right corner, fill in your details, and you'll be ready to start your job search journey.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item contact-anim-zoom-in">
                    <div class="contact-faq-question">
                        <h3>How can I post a job?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>Employers can post jobs by creating an employer account and navigating to the "Post a Job" section. Our platform makes it easy to reach qualified candidates.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item contact-anim-zoom-in">
                    <div class="contact-faq-question">
                        <h3>Is Skillia free to use?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>Yes! Basic job searching and application features are completely free. We also offer premium features for enhanced job seeking and hiring experiences.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item contact-anim-zoom-in">
                    <div class="contact-faq-question">
                        <h3>How do I reset my password?</h3>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>Click on "Forgot Password" on the login page, enter your email address, and we'll send you a link to reset your password securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="contact-map-section contact-anim-fade-up">
        <div class="contact-map-container">
            <h2 class="contact-map-title contact-anim-fade-up">Find Us</h2>
            <div class="contact-map-wrapper contact-anim-zoom-in">
                <iframe
                    class="contact-map-iframe"
                    src="https://www.google.com/maps?q=23.8103,90.4125&z=15&output=embed"
                    width="100%"
                    height="350"
                    style="border:0; border-radius: 20px; box-shadow: 0 8px 32px rgba(81,45,168,0.1);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Skillia Location Map"
                ></iframe>
            </div>
        </div>
    </section>

    <!-- Social Media Section -->
    <section class="contact-social-section contact-anim-fade-up">
        <div class="contact-social-container">
            <h2 class="contact-social-title contact-anim-fade-up">Connect With Us</h2>
            <div class="contact-social-grid">
                <a href="#" class="contact-social-card contact-anim-zoom-in">
                    <i class="ri-facebook-fill"></i>
                    <span>Facebook</span>
                </a>
                <a href="#" class="contact-social-card contact-anim-zoom-in">
                    <i class="ri-twitter-fill"></i>
                    <span>Twitter</span>
                </a>
                <a href="#" class="contact-social-card contact-anim-zoom-in">
                    <i class="ri-linkedin-fill"></i>
                    <span>LinkedIn</span>
                </a>
                <a href="#" class="contact-social-card contact-anim-zoom-in">
                    <i class="ri-instagram-fill"></i>
                    <span>Instagram</span>
                </a>
                <a href="#" class="contact-social-card contact-anim-zoom-in">
                    <i class="ri-youtube-fill"></i>
                    <span>YouTube</span>
                </a>
            </div>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/contact-us.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 