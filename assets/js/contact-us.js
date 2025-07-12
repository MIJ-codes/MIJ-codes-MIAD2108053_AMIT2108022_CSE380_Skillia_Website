// Contact Us Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Animation observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('contact-anim-visible');
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.contact-anim-fade-up, .contact-anim-fade-left, .contact-anim-fade-right, .contact-anim-zoom-in');
    animatedElements.forEach(el => observer.observe(el));

    // FAQ Functionality
    const faqItems = document.querySelectorAll('.contact-faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.contact-faq-question');
        
        question.addEventListener('click', () => {
            // Close other open items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        });
    });

    // Form Interactions
    const form = document.querySelector('.contact-form');
    const inputs = form.querySelectorAll('input, select, textarea');
    const submitBtn = form.querySelector('.contact-submit-btn');

    // Input focus effects
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', () => {
            if (!input.value) {
                input.parentElement.classList.remove('focused');
            }
        });

        // Auto-resize textarea
        if (input.tagName === 'TEXTAREA') {
            input.addEventListener('input', () => {
                input.style.height = 'auto';
                input.style.height = input.scrollHeight + 'px';
            });
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add loading state
        submitBtn.innerHTML = '<span>Sending...</span><i class="ri-loader-4-line"></i>';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            submitBtn.innerHTML = '<span>Message Sent!</span><i class="ri-check-line"></i>';
            submitBtn.style.background = 'linear-gradient(135deg, #4caf50 0%, #66bb6a 100%)';
            
            // Reset form
            setTimeout(() => {
                form.reset();
                submitBtn.innerHTML = '<span>Send Message</span><i class="ri-send-plane-line"></i>';
                submitBtn.disabled = false;
                submitBtn.style.background = 'linear-gradient(135deg, #512da8 0%, #7e57c2 100%)';
            }, 2000);
        }, 1500);
    });

    // Social media card hover effects
    const socialCards = document.querySelectorAll('.contact-social-card');
    
    socialCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-12px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Contact info card animations
    const contactCards = document.querySelectorAll('.contact-info-card');
    
    contactCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Floating elements animation
    const floatingElements = document.querySelectorAll('.contact-element');
    
    floatingElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.5}s`;
    });

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Parallax effect for hero section
    const heroSection = document.querySelector('.contact-hero-section');
    const heroContent = document.querySelector('.contact-hero-content');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (heroContent) {
            heroContent.style.transform = `translateY(${rate}px)`;
        }
    });

    // Form validation
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    
    if (emailInput) {
        emailInput.addEventListener('blur', () => {
            const email = emailInput.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                emailInput.style.borderColor = '#f44336';
                emailInput.style.boxShadow = '0 0 0 3px rgba(244, 67, 54, 0.1)';
            } else {
                emailInput.style.borderColor = '#512da8';
                emailInput.style.boxShadow = '0 0 0 3px rgba(81, 45, 168, 0.1)';
            }
        });
    }
    
    if (phoneInput) {
        phoneInput.addEventListener('blur', () => {
            const phone = phoneInput.value;
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
            
            if (phone && !phoneRegex.test(phone)) {
                phoneInput.style.borderColor = '#f44336';
                phoneInput.style.boxShadow = '0 0 0 3px rgba(244, 67, 54, 0.1)';
            } else {
                phoneInput.style.borderColor = '#512da8';
                phoneInput.style.boxShadow = '0 0 0 3px rgba(81, 45, 168, 0.1)';
            }
        });
    }

    // Loading animation for page elements
    const pageLoadElements = document.querySelectorAll('.contact-hero-content, .contact-info-card, .contact-form-content');
    
    pageLoadElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Interactive map placeholder
    const mapPlaceholder = document.querySelector('.contact-map-placeholder');
    
    if (mapPlaceholder) {
        mapPlaceholder.addEventListener('click', () => {
            mapPlaceholder.style.transform = 'scale(0.95)';
            setTimeout(() => {
                mapPlaceholder.style.transform = 'scale(1)';
            }, 150);
        });
    }

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.contact-submit-btn, .contact-social-card');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .contact-submit-btn,
    .contact-social-card {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(style); 