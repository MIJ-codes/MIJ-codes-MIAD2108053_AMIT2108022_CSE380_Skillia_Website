// Help Center Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Animation observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('help-anim-visible');
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.help-anim-fade-up, .help-anim-fade-left, .help-anim-fade-right, .help-anim-zoom-in');
    animatedElements.forEach(el => observer.observe(el));

    // FAQ Functionality
    const faqItems = document.querySelectorAll('.help-faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.help-faq-question');
        
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

    // Search Functionality
    const searchInput = document.getElementById('helpSearch');
    const searchBtn = document.querySelector('.help-search-btn');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            // Show all items if search is empty
            faqItems.forEach(item => {
                item.style.display = 'block';
                item.style.opacity = '1';
            });
            return;
        }
        
        faqItems.forEach(item => {
            const question = item.querySelector('.help-faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.help-faq-answer p').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.opacity = '1';
                // Highlight matching text
                highlightText(item, searchTerm);
            } else {
                item.style.display = 'none';
                item.style.opacity = '0';
            }
        });
    }
    
    function highlightText(element, searchTerm) {
        const question = element.querySelector('.help-faq-question h3');
        const answer = element.querySelector('.help-faq-answer p');
        
        // Remove existing highlights
        question.innerHTML = question.textContent;
        answer.innerHTML = answer.textContent;
        
        // Add highlights
        if (searchTerm) {
            const questionRegex = new RegExp(`(${searchTerm})`, 'gi');
            const answerRegex = new RegExp(`(${searchTerm})`, 'gi');
            
            question.innerHTML = question.textContent.replace(questionRegex, '<mark style="background: #ff6b35; color: white; padding: 2px 4px; border-radius: 4px;">$1</mark>');
            answer.innerHTML = answer.textContent.replace(answerRegex, '<mark style="background: #ff6b35; color: white; padding: 2px 4px; border-radius: 4px;">$1</mark>');
        }
    }
    
    // Search input event listeners
    searchInput.addEventListener('input', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    searchBtn.addEventListener('click', performSearch);

    // Category card hover effects
    const categoryCards = document.querySelectorAll('.help-category-card');
    
    categoryCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth scrolling for category links
    const categoryLinks = document.querySelectorAll('.help-category-card');
    
    categoryLinks.forEach(link => {
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

    // Search box interactions
    const searchBox = document.querySelector('.help-search-box');
    
    searchBox.addEventListener('focusin', () => {
        searchBox.style.transform = 'scale(1.02)';
    });
    
    searchBox.addEventListener('focusout', () => {
        searchBox.style.transform = 'scale(1)';
    });

    // Floating shapes animation
    const floatingShapes = document.querySelectorAll('.help-shape');
    
    floatingShapes.forEach((shape, index) => {
        shape.style.animationDelay = `${index * 0.5}s`;
    });

    // Parallax effect for hero section
    const heroSection = document.querySelector('.help-hero-section');
    const heroContent = document.querySelector('.help-hero-content');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (heroContent) {
            heroContent.style.transform = `translateY(${rate}px)`;
        }
    });

    // Button hover effects
    const buttons = document.querySelectorAll('.help-btn');
    
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
    const pageLoadElements = document.querySelectorAll('.help-hero-content, .help-search-box, .help-category-card, .help-faq-item');
    
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
    const contactVisual = document.querySelector('.help-contact-visual');
    
    if (contactVisual) {
        contactVisual.addEventListener('mouseenter', () => {
            const shapes = contactVisual.querySelectorAll('.help-shape');
            shapes.forEach((shape, index) => {
                setTimeout(() => {
                    shape.style.transform = 'scale(1.2) rotate(45deg)';
                }, index * 100);
            });
        });
        
        contactVisual.addEventListener('mouseleave', () => {
            const shapes = contactVisual.querySelectorAll('.help-shape');
            shapes.forEach(shape => {
                shape.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    }

    // Section transition effects
    const sections = document.querySelectorAll('.help-content-section');
    
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

    // Add CSS for ripple effect and search highlights
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
        
        .help-btn {
            position: relative;
            overflow: hidden;
        }
        
        .help-shape {
            transition: all 0.3s ease;
        }
        
        .help-search-box {
            transition: all 0.3s ease;
        }
        
        .help-faq-item {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    // Keyboard navigation for accessibility
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            // Add focus styles for keyboard navigation
            const focusableElements = document.querySelectorAll('.help-category-card, .help-btn, .help-search-box input');
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

    // Auto-expand FAQ items when they match search
    function expandMatchingFAQs(searchTerm) {
        if (searchTerm === '') {
            faqItems.forEach(item => {
                item.classList.remove('active');
            });
            return;
        }
        
        faqItems.forEach(item => {
            const question = item.querySelector('.help-faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.help-faq-answer p').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.classList.add('active');
            }
        });
    }
    
    // Update search to also expand matching FAQs
    const originalPerformSearch = performSearch;
    performSearch = function() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        originalPerformSearch();
        expandMatchingFAQs(searchTerm);
    };
}); 