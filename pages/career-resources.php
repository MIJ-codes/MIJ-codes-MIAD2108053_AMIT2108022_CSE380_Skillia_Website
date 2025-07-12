<?php $currentPage = 'career-resources'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Career Resources</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<!-- Floating Background Shapes -->
<div class="floating-shapes">
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
</div>

<?php include '../includes/header.php'; ?>

<div class="career-resources-main">
  <!-- Hero Section -->
  <section class="cr-hero-section">
    <div class="cr-hero-content">
      <h1 class="cr-hero-title">Career Resources</h1>
      <p class="cr-hero-subtitle">Expert tips, guides, and resources to help you grow your career</p>
    </div>
    <div class="animated-blossoms">
      <span></span><span></span><span></span><span></span><span></span>
    </div>
  </section>

  <!-- Categories Section -->
  <section class="cr-categories-section">
    <h2 class="cr-section-title">Resource Categories</h2>
    <div class="cr-grid">
      <div class="cr-card cr-category-card">
        <div class="cr-category-icon"><i class="ri-file-text-line"></i></div>
        <h3 class="cr-category-title">Resume & CV</h3>
        <p class="cr-category-desc">Templates, tips, and best practices for creating standout resumes</p>
      </div>
      <div class="cr-card cr-category-card">
        <div class="cr-category-icon"><i class="ri-user-voice-line"></i></div>
        <h3 class="cr-category-title">Interview Prep</h3>
        <p class="cr-category-desc">Common questions, techniques, and strategies for interview success</p>
      </div>
      <div class="cr-card cr-category-card">
        <div class="cr-category-icon"><i class="ri-graduation-cap-line"></i></div>
        <h3 class="cr-category-title">Skills Development</h3>
        <p class="cr-category-desc">Courses, certifications, and learning paths for career advancement</p>
      </div>
      <div class="cr-card cr-category-card">
        <div class="cr-category-icon"><i class="ri-briefcase-4-line"></i></div>
        <h3 class="cr-category-title">Career Planning</h3>
        <p class="cr-category-desc">Goal setting, career paths, and strategic planning guidance</p>
      </div>
      <div class="cr-card cr-category-card" data-category="networking">
        <div class="cr-category-icon"></div>
        <h3 class="cr-category-title">Networking</h3>
        <p class="cr-category-desc">Building professional relationships and expanding your network</p>
      </div>
      <div class="cr-card cr-category-card">
        <div class="cr-category-icon"><i class="ri-money-dollar-circle-line"></i></div>
        <h3 class="cr-category-title">Salary Negotiation</h3>
        <p class="cr-category-desc">Strategies for negotiating better compensation and benefits</p>
      </div>
    </div>
  </section>

  <!-- Featured Resources Section -->
  <section class="cr-featured-section">
    <h2 class="cr-section-title">Featured Resources</h2>
    <div class="cr-grid">
      <div class="cr-card cr-resource-card">
        <div class="cr-resource-img">
          <img src="../assets/images/resume-template.jpg" alt="Resume Template" />
        </div>
        <span class="cr-resource-tag">Popular</span>
        <h3 class="cr-resource-title">Professional Resume Template</h3>
        <p class="cr-resource-desc">Download our ATS-friendly resume template with expert tips</p>
        <a href="#" class="cr-resource-link">Download Template <i class="ri-download-line"></i></a>
      </div>
      <div class="cr-card cr-resource-card">
        <div class="cr-resource-img">
          <img src="../assets/images/interview-guide.jpg" alt="Interview Guide" />
        </div>
        <span class="cr-resource-tag">New</span>
        <h3 class="cr-resource-title">Complete Interview Guide</h3>
        <p class="cr-resource-desc">Master common interview questions and behavioral techniques</p>
        <a href="#" class="cr-resource-link">Read Guide <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="cr-card cr-resource-card">
        <div class="cr-resource-img">
          <img src="../assets/images/salary-negotiation.jpg" alt="Salary Negotiation" />
        </div>
        <span class="cr-resource-tag">Featured</span>
        <h3 class="cr-resource-title">Salary Negotiation Masterclass</h3>
        <p class="cr-resource-desc">Learn proven strategies to negotiate better compensation</p>
        <a href="#" class="cr-resource-link">Watch Now <i class="ri-play-circle-line"></i></a>
      </div>
    </div>
  </section>

  <!-- Latest Articles Section -->
  <section class="cr-articles-section">
    <h2 class="cr-section-title">Latest Articles</h2>
    <div class="cr-grid">
      <div class="cr-card cr-article-card">
        <div class="cr-article-img">
          <img src="../assets/images/remote-work.jpg" alt="Remote Work" />
        </div>
        <div class="cr-article-meta">
          <span class="cr-article-date">Mar 15, 2024</span>
          <span class="cr-article-category">Remote Work</span>
        </div>
        <h3 class="cr-article-title">10 Tips for Remote Work Success</h3>
        <p class="cr-article-desc">Essential strategies to thrive in remote work environments</p>
        <a href="#" class="cr-article-link">Read More</a>
      </div>
      <div class="cr-card cr-article-card">
        <div class="cr-article-img">
          <img src="../assets/images/career-switch.jpg" alt="Career Switch" />
        </div>
        <div class="cr-article-meta">
          <span class="cr-article-date">Mar 12, 2024</span>
          <span class="cr-article-category">Career Change</span>
        </div>
        <h3 class="cr-article-title">How to Successfully Switch Careers</h3>
        <p class="cr-article-desc">A step-by-step guide to transitioning to a new industry</p>
        <a href="#" class="cr-article-link">Read More</a>
      </div>
      <div class="cr-card cr-article-card">
        <div class="cr-article-img">
          <img src="../assets/images/ai-skills.jpg" alt="AI Skills" />
        </div>
        <div class="cr-article-meta">
          <span class="cr-article-date">Mar 10, 2024</span>
          <span class="cr-article-category">Skills</span>
        </div>
        <h3 class="cr-article-title">AI Skills Every Professional Needs</h3>
        <p class="cr-article-desc">Future-proof your career with essential AI competencies</p>
        <a href="#" class="cr-article-link">Read More</a>
      </div>
    </div>
  </section>

  <!-- Career Tools Section -->
  <section class="cr-tools-section">
    <h2 class="cr-section-title">Career Tools</h2>
    <div class="cr-grid">
      <div class="cr-card cr-tool-card">
        <div class="cr-tool-icon"><i class="ri-calculator-line"></i></div>
        <h3 class="cr-tool-title">Salary Calculator</h3>
        <p class="cr-tool-desc">Calculate your worth based on experience, location, and skills</p>
        <a href="#" class="cr-tool-btn">Calculate Salary</a>
      </div>
      <div class="cr-card cr-tool-card">
        <div class="cr-tool-icon"><i class="ri-file-list-3-line"></i></div>
        <h3 class="cr-tool-title">Resume Builder</h3>
        <p class="cr-tool-desc">Create professional resumes with our easy-to-use builder</p>
        <a href="#" class="cr-tool-btn">Build Resume</a>
      </div>
      <div class="cr-card cr-tool-card">
        <div class="cr-tool-icon"><i class="ri-search-line"></i></div>
        <h3 class="cr-tool-title">Job Matcher</h3>
        <p class="cr-tool-desc">Find jobs that perfectly match your skills and preferences</p>
        <a href="#" class="cr-tool-btn">Find Jobs</a>
      </div>
    </div>
  </section>

  <!-- Events Section -->
  <section class="cr-events-section">
    <h2 class="cr-section-title">Upcoming Events</h2>
    <div class="cr-grid">
      <div class="cr-card cr-event-card">
        <div class="cr-event-date">
          <span class="cr-event-month">MAR</span>
          <span class="cr-event-day">25</span>
          <span class="cr-event-year">2024</span>
        </div>
        <div class="cr-event-content">
          <span class="cr-event-type">Webinar</span>
          <h3 class="cr-event-title">Resume Writing Workshop</h3>
          <p class="cr-event-desc">Learn to create compelling resumes that get you interviews</p>
          <div class="cr-event-details">
            <span><i class="ri-time-line"></i> 2:00 PM EST</span>
            <span><i class="ri-user-line"></i> 150 spots</span>
          </div>
          <a href="#" class="cr-event-btn">Register Now</a>
        </div>
      </div>
      <div class="cr-card cr-event-card">
        <div class="cr-event-date">
          <span class="cr-event-month">APR</span>
          <span class="cr-event-day">02</span>
          <span class="cr-event-year">2024</span>
        </div>
        <div class="cr-event-content">
          <span class="cr-event-type">Workshop</span>
          <h3 class="cr-event-title">Interview Mastery</h3>
          <p class="cr-event-desc">Practice interviews with industry experts and get feedback</p>
          <div class="cr-event-details">
            <span><i class="ri-time-line"></i> 6:00 PM EST</span>
            <span><i class="ri-user-line"></i> 50 spots</span>
          </div>
          <a href="#" class="cr-event-btn">Register Now</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter Section -->
  <section class="cr-newsletter-section">
    <div class="cr-newsletter-container">
      <div class="cr-newsletter-content">
        <h3 class="cr-newsletter-title">Stay Updated</h3>
        <p class="cr-newsletter-desc">Get the latest career tips and resources delivered to your inbox</p>
        <form class="cr-newsletter-form">
          <input type="email" class="cr-newsletter-input" placeholder="Enter your email" required />
          <button type="submit" class="cr-newsletter-btn">Subscribe</button>
        </form>
        <div class="cr-newsletter-terms">
          <input type="checkbox" id="newsletter-terms" required />
          <label for="newsletter-terms">I agree to receive career resources and updates</label>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="cr-faq-section">
    <h2 class="cr-section-title">Frequently Asked Questions</h2>
    <div class="cr-faq-container">
      <div class="cr-faq-card">
        <div class="cr-faq-question">
          How often should I update my resume?
          <i class="cr-faq-icon ri-add-line"></i>
        </div>
        <div class="cr-faq-answer">
          It's recommended to update your resume every 6-12 months, or whenever you gain new skills, complete projects, or change roles. Keep it current with your latest achievements and experiences.
        </div>
      </div>
      <div class="cr-faq-card">
        <div class="cr-faq-question">
          What should I include in a cover letter?
          <i class="cr-faq-icon ri-add-line"></i>
        </div>
        <div class="cr-faq-answer">
          A strong cover letter should include your motivation for the role, relevant experience, specific achievements, and how you can contribute to the company. Keep it concise and tailored to each position.
        </div>
      </div>
      <div class="cr-faq-card">
        <div class="cr-faq-question">
          How do I prepare for a behavioral interview?
          <i class="cr-faq-icon ri-add-line"></i>
        </div>
        <div class="cr-faq-answer">
          Use the STAR method (Situation, Task, Action, Result) to structure your responses. Prepare specific examples from your experience that demonstrate your skills and achievements.
        </div>
      </div>
      <div class="cr-faq-card">
        <div class="cr-faq-question">
          When should I start salary negotiations?
          <i class="cr-faq-icon ri-add-line"></i>
        </div>
        <div class="cr-faq-answer">
          Wait until you have a job offer before discussing salary. Research market rates for your position and experience level, and be prepared to justify your desired compensation.
        </div>
      </div>
    </div>
  </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/career-resources.js"></script>
<?php include '../includes/footer.php'; ?>

<script>
// FAQ Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
  const faqCards = document.querySelectorAll('.cr-faq-card');
  
  faqCards.forEach(card => {
    const question = card.querySelector('.cr-faq-question');
    const answer = card.querySelector('.cr-faq-answer');
    
    question.addEventListener('click', () => {
      const isActive = card.classList.contains('active');
      
      // Close all other cards
      faqCards.forEach(otherCard => {
        otherCard.classList.remove('active');
      });
      
      // Toggle current card
      if (!isActive) {
        card.classList.add('active');
      }
    });
  });
});
</script>

</body>
</html> 