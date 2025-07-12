// Skillia About Us Page - Modular JS
// Add About Us page-specific interactivity here, step by step. 

// 1. Fade-in, slide-in, zoom-in animations on scroll
function initAboutUsAnimations() {
  const animElements = document.querySelectorAll('.about-anim-fade-up, .about-anim-fade-left, .about-anim-fade-right, .about-anim-zoom-in');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('about-anim-visible');
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -100px 0px' });
  animElements.forEach(el => observer.observe(el));
}

// 2. Animated number counters in Stats section
function initAboutUsCounters() {
  const counters = document.querySelectorAll('.about-stat-number[data-target]');
  counters.forEach(counter => {
    let started = false;
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !started) {
          started = true;
          const target = +counter.getAttribute('data-target');
          let count = 0;
          const speed = 200;
          function updateCount() {
            const increment = target / speed;
            if (count < target) {
              count += increment;
              counter.innerText = Math.ceil(count).toLocaleString() + '+';
              setTimeout(updateCount, 1);
            } else {
              counter.innerText = target.toLocaleString() + '+';
            }
          }
          updateCount();
          observer.unobserve(counter);
        }
      });
    }, { threshold: 0.5 });
    observer.observe(counter);
  });
}

// 3. Timeline progress bar animation
function initAboutUsTimeline() {
  const timelineProgress = document.querySelector('.about-timeline-progress');
  if (timelineProgress) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            timelineProgress.style.height = '100%';
          }, 500);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });
    observer.observe(timelineProgress);
  }
}

// 4. Team card 3D tilt effect
function initAboutUsTeamTilt() {
  const teamMembers = document.querySelectorAll('.about-team-member');
  teamMembers.forEach(member => {
    member.addEventListener('mousemove', (e) => {
      const cardRect = member.getBoundingClientRect();
      const x = e.clientX - cardRect.left;
      const y = e.clientY - cardRect.top;
      const centerX = cardRect.width / 2;
      const centerY = cardRect.height / 2;
      const rotateX = (y - centerY) / 10;
      const rotateY = -(x - centerX) / 10;
      member.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
    });
    member.addEventListener('mouseleave', () => {
      member.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
      setTimeout(() => {
        member.style.transition = '';
      }, 300);
    });
  });
}

// 5. Value card icon bounce/scale on hover
function initAboutUsValueCards() {
  const valueCards = document.querySelectorAll('.about-value-card');
  valueCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      const icon = card.querySelector('.about-value-icon i');
      if (icon) {
        icon.style.transform = 'scale(1.2) rotateY(360deg)';
        icon.style.transition = 'transform 0.5s ease';
      }
    });
    card.addEventListener('mouseleave', () => {
      const icon = card.querySelector('.about-value-icon i');
      if (icon) {
        icon.style.transform = 'scale(1) rotateY(0)';
      }
    });
  });
}

// 6. Button ripple effect
function initAboutUsButtonRipple() {
  const buttons = document.querySelectorAll('.about-btn');
  buttons.forEach(button => {
    button.addEventListener('click', function(e) {
      const ripple = document.createElement('span');
      ripple.className = 'about-btn-ripple';
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.width = ripple.style.height = `${size}px`;
      ripple.style.left = `${e.clientX - rect.left - size/2}px`;
      ripple.style.top = `${e.clientY - rect.top - size/2}px`;
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });
}

// 7. CTA parallax effect for floating shapes
function initAboutUsParallax() {
  window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;
    const ctaSection = document.querySelector('.about-contact-section');
    const shapes = document.querySelectorAll('.about-shape');
    if (ctaSection && shapes.length && scrollPosition < ctaSection.offsetTop + ctaSection.offsetHeight) {
      shapes.forEach((shape, idx) => {
        const speed = 0.2 + (idx * 0.1);
        shape.style.transform = `translateY(${scrollPosition * speed}px)`;
      });
    }
  });
}

// Mission image parallax effect
function initAboutUsMissionParallax() {
  const imgContainer = document.querySelector('.about-mission-img-container');
  if (!imgContainer) return;
  imgContainer.classList.add('about-mission-parallax');
  imgContainer.addEventListener('mousemove', (e) => {
    const rect = imgContainer.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const moveX = (x - rect.width / 2) / 18;
    const moveY = (y - rect.height / 2) / 18;
    imgContainer.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.04)`;
  });
  imgContainer.addEventListener('mouseleave', () => {
    imgContainer.style.transform = '';
  });
}

// Staggered text reveal for mission section
function initAboutUsMissionStaggered() {
  const missionText = document.querySelector('.about-mission-text');
  if (!missionText) return;
  const children = missionText.querySelectorAll('.about-mission-title, p');
  children.forEach((el, i) => {
    el.style.transitionDelay = `${0.15 + i * 0.18}s`;
  });
}

// 8. Add fade/slide/zoom classes to elements (for demo, you can add these in HTML as needed)
document.addEventListener('DOMContentLoaded', function() {
  initAboutUsAnimations();
  initAboutUsCounters();
  initAboutUsTimeline();
  initAboutUsTeamTilt();
  initAboutUsValueCards();
  initAboutUsButtonRipple();
  initAboutUsParallax();
  initAboutUsMissionParallax();
  initAboutUsMissionStaggered();
});

// Add CSS for .about-anim-fade-up, .about-anim-fade-left, .about-anim-fade-right, .about-anim-zoom-in, .about-anim-visible, .about-btn-ripple in your about-us.css for smooth transitions. 