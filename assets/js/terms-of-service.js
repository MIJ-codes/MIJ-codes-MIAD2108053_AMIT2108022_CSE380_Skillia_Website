// Terms of Service Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Animation observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('terms-anim-visible');
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.terms-anim-fade-up, .terms-anim-fade-left, .terms-anim-fade-right, .terms-anim-zoom-in');
    animatedElements.forEach(el => observer.observe(el));

    // Smooth scrolling for table of contents
    const tocLinks = document.querySelectorAll('.terms-toc-card');
    
    tocLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const headerOffset = 100; // Account for fixed header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Card hover effects
    const contentCards = document.querySelectorAll('.terms-content-card, .terms-accounts-card, .terms-conduct-item, .terms-ip-card, .terms-liability-item');
    
    contentCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // TOC card hover effects
    const tocCardsHover = document.querySelectorAll('.terms-toc-card');
    
    tocCardsHover.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Service item hover effects
    const serviceItems = document.querySelectorAll('.terms-service-item');
    
    serviceItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
        
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Floating shapes animation
    const floatingShapes = document.querySelectorAll('.terms-shape');
    
    floatingShapes.forEach((shape, index) => {
        shape.style.animationDelay = `${index * 0.5}s`;
    });

    // Parallax effect for hero section
    const heroSection = document.querySelector('.terms-hero-section');
    const heroContent = document.querySelector('.terms-hero-content');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (heroContent) {
            heroContent.style.transform = `translateY(${rate}px)`;
        }
    });

    // Active section highlighting
    const sections = document.querySelectorAll('.terms-content-section');
    const tocCards = document.querySelectorAll('.terms-toc-card');
    
    function updateActiveSection() {
        const scrollPosition = window.scrollY + 200;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Remove active class from all TOC cards
                tocCards.forEach(card => {
                    card.classList.remove('active');
                });
                
                // Add active class to corresponding TOC card
                const activeTocCard = document.querySelector(`.terms-toc-card[href="#${sectionId}"]`);
                if (activeTocCard) {
                    activeTocCard.classList.add('active');
                }
            }
        });
    }
    
    window.addEventListener('scroll', updateActiveSection);
    updateActiveSection(); // Initial call

    // Button hover effects
    const buttons = document.querySelectorAll('.terms-btn');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add ripple effect to buttons
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

    // Loading animation for page elements
    const pageLoadElements = document.querySelectorAll('.terms-hero-content, .terms-toc-card, .terms-content-card, .terms-service-item');
    
    pageLoadElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Interactive visual effects
    const contactVisual = document.querySelector('.terms-contact-visual');
    
    if (contactVisual) {
        contactVisual.addEventListener('mouseenter', () => {
            const shapes = contactVisual.querySelectorAll('.terms-shape');
            shapes.forEach((shape, index) => {
                setTimeout(() => {
                    shape.style.transform = 'scale(1.2) rotate(45deg)';
                }, index * 100);
            });
        });
        
        contactVisual.addEventListener('mouseleave', () => {
            const shapes = contactVisual.querySelectorAll('.terms-shape');
            shapes.forEach(shape => {
                shape.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    }

    // Section transition effects
    sections.forEach(section => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        
        observer.observe(section);
    });

    // Add CSS for active TOC card and ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .terms-toc-card.active {
            background: linear-gradient(135deg, #512da8 0%, #7e57c2 100%);
            color: #fff;
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 12px 40px rgba(81,45,168,0.3);
        }
        
        .terms-toc-card.active i {
            color: #fff;
        }
        
        .terms-toc-card.active span {
            color: #fff;
        }
        
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
        
        .terms-btn {
            position: relative;
            overflow: hidden;
        }
        
        .terms-shape {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    // Keyboard navigation for accessibility
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            // Add focus styles for keyboard navigation
            const focusableElements = document.querySelectorAll('.terms-toc-card, .terms-btn');
            focusableElements.forEach(el => {
                el.addEventListener('focus', () => {
                    el.style.outline = '2px solid #512da8';
                    el.style.outlineOffset = '2px';
                });
                
                el.addEventListener('blur', () => {
                    el.style.outline = 'none';
                });
            });
        }
    });

    // Scroll to top functionality
    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    // Add scroll to top button when scrolling down
    let scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="ri-arrow-up-line"></i>';
    scrollToTopBtn.className = 'scroll-to-top-btn';
    scrollToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #512da8 0%, #7e57c2 100%);
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 20px rgba(81,45,168,0.3);
    `;
    
    document.body.appendChild(scrollToTopBtn);
    
    scrollToTopBtn.addEventListener('click', scrollToTop);
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.opacity = '1';
            scrollToTopBtn.style.visibility = 'visible';
        } else {
            scrollToTopBtn.style.opacity = '0';
            scrollToTopBtn.style.visibility = 'hidden';
        }
    });
}); 