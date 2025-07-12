// Company Directory Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initCompanyAnimations();
    
    // Initialize search functionality
    initCompanySearch();
    
    // Initialize filter functionality
    initCompanyFilters();
    
    // Initialize favorite functionality
    initCompanyFavorites();
    
    // Initialize load more functionality
    initLoadMore();
});

// Initialize scroll animations
function initCompanyAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.company-anim-fade-up, .company-anim-fade-left, .company-anim-fade-right, .company-anim-zoom-in');
    animatedElements.forEach(el => observer.observe(el));
}

// Initialize company search functionality
function initCompanySearch() {
    const searchInput = document.querySelector('.company-search-input');
    const companyCards = document.querySelectorAll('.company-card, .company-featured-card');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            companyCards.forEach(card => {
                const companyName = card.querySelector('.company-name').textContent.toLowerCase();
                const companyIndustry = card.querySelector('.company-industry').textContent.toLowerCase();
                const companyDescription = card.querySelector('.company-description').textContent.toLowerCase();
                
                const matches = companyName.includes(searchTerm) || 
                              companyIndustry.includes(searchTerm) || 
                              companyDescription.includes(searchTerm);
                
                if (matches || searchTerm === '') {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                } else {
                    card.style.opacity = '0.5';
                    card.style.display = 'none';
                }
            });
        });
    }
}

// Initialize company filters
function initCompanyFilters() {
    const filters = document.querySelectorAll('.company-filter');
    const companyCards = document.querySelectorAll('.company-card, .company-featured-card');
    
    filters.forEach(filter => {
        filter.addEventListener('change', function() {
            const selectedIndustry = document.querySelector('.company-filter[data-type="industry"]')?.value;
            const selectedSize = document.querySelector('.company-filter[data-type="size"]')?.value;
            const selectedLocation = document.querySelector('.company-filter[data-type="location"]')?.value;
            
            companyCards.forEach(card => {
                const industry = card.getAttribute('data-industry');
                const size = card.getAttribute('data-size');
                const location = card.getAttribute('data-location');
                
                const industryMatch = !selectedIndustry || industry === selectedIndustry;
                const sizeMatch = !selectedSize || size === selectedSize;
                const locationMatch = !selectedLocation || location === selectedLocation;
                
                if (industryMatch && sizeMatch && locationMatch) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                } else {
                    card.style.opacity = '0.5';
                    card.style.display = 'none';
                }
            });
        });
    });
}

// Initialize company favorites
function initCompanyFavorites() {
    const favoriteButtons = document.querySelectorAll('.company-btn-secondary');
    
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('ri-heart-line')) {
                icon.classList.remove('ri-heart-line');
                icon.classList.add('ri-heart-fill');
                this.style.color = '#e74c3c';
                showNotification('Company added to favorites!');
            } else {
                icon.classList.remove('ri-heart-fill');
                icon.classList.add('ri-heart-line');
                this.style.color = '#667eea';
                showNotification('Company removed from favorites!');
            }
        });
    });
}

// Initialize load more functionality
function initLoadMore() {
    const loadMoreBtn = document.querySelector('.company-btn-outline');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.textContent = 'Loading...';
            this.disabled = true;
            
            // Simulate loading more companies
            setTimeout(() => {
                this.textContent = 'Load More Companies';
                this.disabled = false;
                showNotification('More companies loaded!');
            }, 2000);
        });
    }
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'company-notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px 25px;
        border-radius: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Parallax effect for hero section
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const heroSection = document.querySelector('.company-hero-section');
    
    if (heroSection) {
        const rate = scrolled * -0.5;
        heroSection.style.transform = `translateY(${rate}px)`;
    }
});

// Interactive hover effects for cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.company-stat-card, .company-culture-card, .company-leader-card, .company-press-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Animated progress bars (if needed)
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.company-progress-bar');
    
    progressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.width = width + '%';
        }, 500);
    });
}

// Contact form validation (if needed)
function initContactForm() {
    const contactForm = document.querySelector('.company-contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const email = this.querySelector('input[type="email"]').value;
            const message = this.querySelector('textarea').value;
            
            if (!email || !message) {
                alert('Please fill in all fields');
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you for your message! We\'ll get back to you soon.');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
}

// Initialize contact form if it exists
document.addEventListener('DOMContentLoaded', function() {
    initContactForm();
});

// Add loading animation for images
function initImageLoading() {
    const images = document.querySelectorAll('.company-leader-photo img, .company-overview-img-container img');
    
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.style.opacity = '0.5';
            this.style.filter = 'grayscale(100%)';
        });
    });
}

// Initialize image loading
document.addEventListener('DOMContentLoaded', function() {
    initImageLoading();
});

// Add keyboard navigation support
document.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        document.body.classList.add('keyboard-navigation');
    }
});

document.addEventListener('mousedown', function() {
    document.body.classList.remove('keyboard-navigation');
});

// Add focus styles for accessibility
document.addEventListener('DOMContentLoaded', function() {
    const focusableElements = document.querySelectorAll('a, button, input, textarea, select');
    
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #667eea';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
});

// Performance optimization: Throttle scroll events
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Apply throttling to scroll events
window.addEventListener('scroll', throttle(function() {
    // Scroll-based animations can go here
}, 16)); // ~60fps

// Add CSS for keyboard navigation
const style = document.createElement('style');
style.textContent = `
    .keyboard-navigation *:focus {
        outline: 2px solid #667eea !important;
        outline-offset: 2px !important;
    }
`;
document.head.appendChild(style); 