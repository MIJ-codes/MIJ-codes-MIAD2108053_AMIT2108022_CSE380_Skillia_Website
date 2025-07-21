<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - For Job Seekers</title>
  <link rel="stylesheet" href="/Skillia/assets/css/style.css" />
  <link rel="stylesheet" href="/Skillia/assets/css/job-seekers.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<?php $currentPage = 'job-seekers'; ?>
<?php include '../includes/header.php'; ?>
<div id="main" class="fade-in" style="background: var(--bg-light); min-height: 100vh;">
  <!-- Hero Section -->
  <section id="hero" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; position: relative; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); overflow: hidden; padding: 2rem 0;">
    <div class="hero-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; max-width: 1200px; width: 100%; align-items: center; z-index: 2; position: relative;">
      <div class="hero-text" style="color: var(--white);">
        <h1 class="hero-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2;">Find Your Dream Job</h1>
        <p class="hero-subtitle" style="font-size: 1.5rem; margin-bottom: 2rem; opacity: 0.9;">Explore thousands of opportunities tailored just for you</p>
        <div class="hero-stats" style="display: flex; gap: 2rem; margin-top: 2rem;">
          <div class="stat-item" style="text-align: center;">
            <span class="stat-number" data-target="15000" style="display: block; font-size: 2rem; font-weight: 700; color: var(--white);">0</span>
            <span class="stat-label" style="font-size: 0.9rem; opacity: 0.8; margin-top: 0.25rem;">Active Jobs</span>
          </div>
          <div class="stat-item" style="text-align: center;">
            <span class="stat-number" data-target="2500" style="display: block; font-size: 2rem; font-weight: 700; color: var(--white);">0</span>
            <span class="stat-label" style="font-size: 0.9rem; opacity: 0.8; margin-top: 0.25rem;">Companies</span>
          </div>
          <div class="stat-item" style="text-align: center;">
            <span class="stat-number" data-target="98" style="display: block; font-size: 2rem; font-weight: 700; color: var(--white);">0</span>
            <span class="stat-label" style="font-size: 0.9rem; opacity: 0.8; margin-top: 0.25rem;">Success Rate</span>
          </div>
        </div>
      </div>
      <div class="hero-visual" style="position: relative; height: 400px;">
        <div class="floating-card card-1"><i class="ri-briefcase-line"></i><span>Software Engineer</span></div>
        <div class="floating-card card-2"><i class="ri-palette-line"></i><span>UI/UX Designer</span></div>
        <div class="floating-card card-3"><i class="ri-bar-chart-line"></i><span>Data Analyst</span></div>
        <div class="floating-card card-4"><i class="ri-customer-service-line"></i><span>Marketing Manager</span></div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" style="padding: 4rem 0; background: var(--white);">
    <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
      <h2 class="section-title" style="font-size: 2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Your Journey Starts Here</h2>
      <p class="section-subtitle" style="font-size: 1.1rem; color: var(--text-medium); max-width: 600px; margin: 0 auto;">Choose your path to career success</p>
    </div>
    <div class="features-grid">
      <!-- Feature Cards -->
      <div class="feature-card-wrapper">
        <div class="feature-card">
          <div class="card-icon"><i class="ri-search-line"></i></div>
          <div class="card-content">
            <h3>Browse Jobs</h3>
            <p>Discover thousands of job opportunities across various industries and experience levels.</p>
            <ul class="feature-list">
              <li><i class="ri-check-line"></i> Advanced search filters</li>
              <li><i class="ri-check-line"></i> Location-based results</li>
              <li><i class="ri-check-line"></i> Salary insights</li>
            </ul>
            <a href="/Skillia/pages/job-board.php" class="feature-btn"><span>Start Browsing</span> <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
      <div class="feature-card-wrapper">
        <div class="feature-card">
          <div class="card-icon"><i class="ri-notification-3-line"></i></div>
          <div class="card-content">
            <h3>Job Alerts</h3>
            <p>Stay updated with instant notifications for jobs that match your interests.</p>
            <ul class="feature-list">
              <li><i class="ri-check-line"></i> Customizable alerts</li>
              <li><i class="ri-check-line"></i> Email & SMS options</li>
              <li><i class="ri-check-line"></i> Never miss an opportunity</li>
            </ul>
            <a href="/Skillia/pages/job-alerts.php" class="feature-btn"><span>Set Alerts</span> <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
      <div class="feature-card-wrapper">
        <div class="feature-card">
          <div class="card-icon"><i class="ri-book-open-line"></i></div>
          <div class="card-content">
            <h3>Career Resources</h3>
            <p>Access expert tips, guides, and resources to boost your career journey.</p>
            <ul class="feature-list">
              <li><i class="ri-check-line"></i> Resume & interview tips</li>
              <li><i class="ri-check-line"></i> Career growth guides</li>
              <li><i class="ri-check-line"></i> Industry insights</li>
            </ul>
            <a href="/Skillia/pages/career-resources.php" class="feature-btn"><span>Explore Resources</span> <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
      <div class="feature-card-wrapper">
        <div class="feature-card">
          <div class="card-icon"><i class="ri-money-dollar-circle-line"></i></div>
          <div class="card-content">
            <h3>Salary Guide</h3>
            <p>Get up-to-date salary data and plan your next career move with confidence.</p>
            <ul class="feature-list">
              <li><i class="ri-check-line"></i> Salary calculator</li>
              <li><i class="ri-check-line"></i> Market trends</li>
              <li><i class="ri-check-line"></i> Negotiation tips</li>
            </ul>
            <a href="/Skillia/pages/salary-guide.php" class="feature-btn"><span>View Guide</span> <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Success Stories Section -->
  <?php
  require_once '../includes/db.php';
  $successStories = [];
  $stmt = $pdo->prepare('SELECT name, job_title, company, story, image_url FROM success_stories WHERE status IS NULL OR status = ? ORDER BY submitted_at DESC');
  $stmt->execute(['approved']);
  while ($row = $stmt->fetch()) {
    $successStories[] = [
      'name' => $row['name'],
      'job_title' => $row['job_title'],
      'company' => $row['company'],
      'story' => $row['story'],
      'image' => $row['image_url'] ? $row['image_url'] : 'https://via.placeholder.com/80x80/512da8/ffffff?text=' . urlencode(substr($row['name'],0,1)),
  ];
  }
  ?>
  <section id="success-stories" style="padding: 4rem 0; background: var(--bg-light);">
    <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
      <h2 class="section-title" style="font-size: 2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Success Stories</h2>
      <p class="section-subtitle" style="font-size: 1.1rem; color: var(--text-medium); max-width: 600px; margin: 0 auto;">Real people, real career transformations</p>
    </div>
    <div class="slider-controls" style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
      <div class="stories-slider" style="max-width: 800px; margin: 0 auto; position: relative; height: 300px; overflow: visible; flex: 1; display: flex; align-items: center;">
        <button class="slider-btn slider-btn-left" aria-label="Previous Story" style="background: var(--primary); color: var(--white); border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0.85; position: absolute; left: -60px; top: 50%; transform: translateY(-50%); z-index: 2;"><i class="ri-arrow-left-s-line"></i></button>
        <?php foreach ($successStories as $i => $story): ?>
        <div class="story-card<?php if($i === 0) echo ' active'; ?>">
          <div class="story-image"><img src="<?= htmlspecialchars($story['image']) ?>" alt="Success Story" /></div>
          <div class="story-content">
            <p class="story-text">"<?= htmlspecialchars($story['story']) ?>"</p>
            <div class="story-author"><strong><?= htmlspecialchars($story['name']) ?></strong><span><?= htmlspecialchars($story['job_title']) ?> at <?= htmlspecialchars($story['company']) ?></span></div>
          </div>
        </div>
        <?php endforeach; ?>
        <button class="slider-btn slider-btn-right" aria-label="Next Story" style="background: var(--primary); color: var(--white); border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0.85; position: absolute; right: -60px; top: 50%; transform: translateY(-50%); z-index: 2;"><i class="ri-arrow-right-s-line"></i></button>
      </div>
    </div>
    <div class="slider-dots" style="display: flex; justify-content: center; gap: 1rem; margin-top: 2rem;">
      <?php foreach ($successStories as $i => $story): ?>
        <span class="dot<?php if($i === 0) echo ' active'; ?>" data-slide="<?= $i ?>"></span>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- CTA Section -->
  <section id="cta" style="padding: 4rem 0; background: var(--primary); text-align: center;">
    <div class="cta-content" style="max-width: 600px; margin: 0 auto; position: relative; z-index: 2;">
      <h2 style="font-size: 2rem; font-weight: 700; color: var(--white); margin-bottom: 1rem;">Ready to Start Your Journey?</h2>
      <p style="font-size: 1.1rem; color: rgba(255, 255, 255, 0.9); margin-bottom: 2rem;">Join thousands of job seekers who found their perfect match</p>
      <div class="cta-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="/Skillia/pages/job-board.php" class="cta-btn secondary" style="padding: 1rem 2rem; border-radius: 8px; background: transparent; color: var(--white); border: 2px solid var(--white); font-weight: 600; text-decoration: none;">Browse Jobs Now</a>
      </div>
    </div>
  </section>
</div>
<script src="/Skillia/assets/js/main.js"></script>
<script src="/Skillia/assets/js/job-seekers.js"></script>
<script src="/Skillia/assets/js/particles.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 