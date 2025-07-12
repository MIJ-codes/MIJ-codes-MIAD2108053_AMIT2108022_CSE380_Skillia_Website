// Job Seekers Page JS (modular, page-specific)
(function() {
  // =============================
  // HERO COUNTER ANIMATIONS
  // =============================
  function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      if (target === 98) {
        element.textContent = Math.floor(current) + '%';
      } else {
        element.textContent = Math.floor(current).toLocaleString();
      }
    }, 16);
  }
  // Initialize counters when hero section is visible
  const heroObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
          const target = parseInt(stat.getAttribute('data-target'));
          animateCounter(stat, target, 2500);
        });
        heroObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });
  const heroSection = document.getElementById('hero');
  if (heroSection) {
    heroObserver.observe(heroSection);
  }

  // =============================
  // FLOATING CARDS INTERACTION
  // =============================
  const floatingCards = document.querySelectorAll('.floating-card');
  floatingCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.animationPlayState = 'paused';
      this.style.transform = 'scale(1.1) translateY(-10px)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.animationPlayState = 'running';
      this.style.transform = '';
    });
    card.addEventListener('click', function() {
      const jobType = this.querySelector('span').textContent;
      // Optionally show a notification if global function exists
      if (typeof showNotification === 'function') {
        showNotification(`Searching for ${jobType} positions...`, 'info');
      }
      setTimeout(() => {
        window.location.href = `/Skillia/pages/job-board.php?search=${encodeURIComponent(jobType)}`;
      }, 1000);
    });
  });

  // =============================
  // FEATURE CARDS ENHANCED INTERACTIONS
  // =============================
  const featureCards = document.querySelectorAll('.feature-card');
  featureCards.forEach(card => {
    // Magnetic effect
    card.addEventListener('mousemove', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const deltaX = (x - centerX) / centerX;
      const deltaY = (y - centerY) / centerY;
      this.style.transform = `perspective(1000px) rotateX(${deltaY * 5}deg) rotateY(${deltaX * 5}deg) translateZ(10px)`;
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = '';
    });
    // Click ripple animation
    card.addEventListener('click', function(e) {
      if (!e.target.closest('.feature-btn')) {
        const ripple = document.createElement('div');
        ripple.className = 'ripple-effect';
        ripple.style.cssText = `
          position: absolute;
          width: 20px;
          height: 20px;
          background: rgba(81, 45, 168, 0.3);
          border-radius: 50%;
          transform: scale(0);
          animation: ripple 0.6s linear;
          left: ${e.offsetX - 10}px;
          top: ${e.offsetY - 10}px;
        `;
        this.appendChild(ripple);
        setTimeout(() => { ripple.remove(); }, 600);
      }
    });
  });
  // Add ripple animation CSS if not present
  if (!document.getElementById('ripple-style')) {
    const rippleStyle = document.createElement('style');
    rippleStyle.id = 'ripple-style';
    rippleStyle.textContent = `@keyframes ripple { to { transform: scale(20); opacity: 0; } }`;
    document.head.appendChild(rippleStyle);
  }

  // =============================
  // SUCCESS STORIES SLIDER
  // =============================
  const storyCards = document.querySelectorAll('.story-card');
  const dots = document.querySelectorAll('.dot');
  let currentSlide = 0;
  let slideInterval;
  function showSlide(index) {
    storyCards.forEach((card, i) => {
      card.classList.toggle('active', i === index);
    });
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
    currentSlide = index;
  }
  function nextSlide() {
    const nextIndex = (currentSlide + 1) % storyCards.length;
    showSlide(nextIndex);
  }
  function startSlider() {
    if (slideInterval) clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
  }
  // Remove all pause/restart logic for continuous movement
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      showSlide(index);
      // Do not stop or restart the slider
    });
  });
  const sliderContainer = document.querySelector('.stories-slider');
  if (sliderContainer) {
    showSlide(0); // Ensure first card is shown on load
    startSlider(); // Start the slider only once
    // Add button navigation
    const leftBtn = sliderContainer.querySelector('.slider-btn-left');
    const rightBtn = sliderContainer.querySelector('.slider-btn-right');
    if (leftBtn) {
      leftBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const prevIndex = currentSlide === 0 ? storyCards.length - 1 : currentSlide - 1;
        showSlide(prevIndex);
      });
    }
    if (rightBtn) {
      rightBtn.addEventListener('click', function(e) {
        e.preventDefault();
        nextSlide();
      });
    }
  }
  // Touch/swipe support (do not pause slider)
  let touchStartX = 0, touchEndX = 0;
  if (sliderContainer) {
    sliderContainer.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
    });
    sliderContainer.addEventListener('touchend', e => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    });
  }
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe right
        const prevIndex = currentSlide === 0 ? storyCards.length - 1 : currentSlide - 1;
        showSlide(prevIndex);
      } else {
        // Swipe left
        nextSlide();
      }
      // Do not stop or restart the slider
    }
  }

  // =============================
  // SCROLL REVEAL ANIMATIONS
  // =============================
  const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -100px 0px' };
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        // Stagger for feature cards
        if (entry.target.classList.contains('feature-card')) {
          const cards = Array.from(document.querySelectorAll('.feature-card'));
          const index = cards.indexOf(entry.target);
          entry.target.style.animationDelay = `${index * 0.1}s`;
        }
        revealObserver.unobserve(entry.target);
      }
    });
  }, observerOptions);
  const revealElements = document.querySelectorAll('.feature-card, .section-header, .story-card, .cta-content');
  revealElements.forEach(el => {
    el.classList.add('scroll-reveal');
    revealObserver.observe(el);
  });

  // =============================
  // PARALLAX SCROLLING EFFECTS
  // =============================
  function handleParallax() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.hero-bg-animation, .floating-elements');
    parallaxElements.forEach(element => {
      const speed = 0.5;
      element.style.transform = `translateY(${scrolled * speed}px)`;
    });
    // Parallax for floating cards
    const floatingCards = document.querySelectorAll('.floating-card');
    floatingCards.forEach((card, index) => {
      const speed = 0.2 + (index * 0.1);
      const yPos = scrolled * speed;
      card.style.transform = `translateY(${yPos}px)`;
    });
  }
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(() => {
        handleParallax();
        ticking = false;
      });
      ticking = true;
    }
  });

  // Log initialization
  console.log('Job Seekers page JS loaded.');
})();

// === Visual Effects Initialization (merged from job-seekers-effects.js) ===
(function(){
  // 1. Add animated gradient overlay to hero
  const hero = document.getElementById('hero');
  if (hero && !hero.querySelector('.hero-gradient-overlay')) {
    const overlay = document.createElement('div');
    overlay.className = 'hero-gradient-overlay';
    hero.appendChild(overlay);
  }

  // 2. Initialize particles in hero and features
  if (window.SkilliaParticles) {
    // Add a container for particles if not present
    if (!hero.querySelector('.particles-container')) {
      const pc = document.createElement('div');
      pc.className = 'particles-container';
      hero.appendChild(pc);
      SkilliaParticles.createParticles('.particles-container', {count: 36});
    }
    const features = document.getElementById('features');
    if (features && !features.querySelector('.particles-container')) {
      const pc2 = document.createElement('div');
      pc2.className = 'particles-container';
      features.appendChild(pc2);
      SkilliaParticles.createParticles('#features .particles-container', {count: 24, minSize: 2, maxSize: 5});
    }
  }

  // Log
  console.log('Job Seekers visual effects initialized.');
})(); 