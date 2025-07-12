<?php $currentPage = 'job-alerts'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Job Alerts</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/job-alerts.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<?php include '../includes/header.php'; ?>

<!-- Hero Section -->
<div class="ja-hero-section">
  <div class="ja-hero-bg"></div>
  <div class="ja-hero-content">
    <h1 class="ja-hero-title">Job Alerts</h1>
    <p class="ja-hero-subtitle">Get notified instantly when jobs matching your interests are posted</p>
  </div>
  <div class="animated-bells">
    <span style="background:rgba(179,136,255,0.18);"></span>
    <span style="background:rgba(179,136,255,0.18);"></span>
    <span style="background:rgba(179,136,255,0.18);"></span>
    <span style="background:rgba(179,136,255,0.18);"></span>
    <span style="background:rgba(179,136,255,0.18);"></span>
  </div>
</div>

<!-- Setup Section -->
<div class="ja-setup-section">
  <div class="ja-setup-container">
    <h2 class="ja-setup-title">Set Up Your Job Alerts</h2>
    <form class="ja-alert-form">
      <div class="ja-form-row">
        <div class="ja-form-group">
          <label for="job-title">Job Title/Keywords</label>
          <input type="text" id="job-title" placeholder="e.g., Software Engineer, Marketing Manager">
        </div>
        <div class="ja-form-group">
          <label for="location">Location</label>
          <input type="text" id="location" placeholder="e.g., New York, Remote">
        </div>
      </div>
      
      <div class="ja-form-row">
        <div class="ja-form-group">
          <label for="experience">Experience Level</label>
          <select id="experience">
            <option value="">Any Level</option>
            <option value="entry">Entry Level</option>
            <option value="mid">Mid Level</option>
            <option value="senior">Senior Level</option>
            <option value="executive">Executive</option>
          </select>
        </div>
        <div class="ja-form-group">
          <label for="salary">Salary Range</label>
          <select id="salary">
            <option value="">Any Salary</option>
            <option value="30-50">$30K - $50K</option>
            <option value="50-80">$50K - $80K</option>
            <option value="80-120">$80K - $120K</option>
            <option value="120+">$120K+</option>
          </select>
        </div>
      </div>
      
      <div class="ja-form-group">
        <label for="frequency">Alert Frequency</label>
        <select id="frequency">
          <option value="daily">Daily</option>
          <option value="weekly">Weekly</option>
          <option value="instant">Instant</option>
        </select>
      </div>
      
      <button type="submit" class="ja-submit-btn">
        <i class="ri-notification-3-line"></i>
        Create Job Alert
      </button>
    </form>
  </div>
</div>

<!-- Manage Section -->
<div class="ja-manage-section">
  <div class="ja-manage-container">
    <h2 class="ja-manage-title">Manage Your Alerts</h2>
    <div class="ja-alerts-grid">
      <div class="ja-alert-card">
        <div class="ja-alert-header">
          <span class="ja-alert-name" style="color:#7c4dff;">Software Developer</span>
          <span class="ja-alert-status active" style="background:rgba(124,77,255,0.10);color:#7c4dff;">Active</span>
        </div>
        <div class="ja-alert-details">
          <p><strong>Location:</strong> Remote, New York</p>
          <p><strong>Experience:</strong> Mid Level</p>
          <p><strong>Frequency:</strong> Daily</p>
        </div>
        <div class="ja-alert-actions">
          <button class="ja-action-btn edit" style="background:rgba(124,77,255,0.10);color:#7c4dff;">Edit</button>
          <button class="ja-action-btn delete">Delete</button>
        </div>
      </div>
      
      <div class="ja-alert-card">
        <div class="ja-alert-header">
          <span class="ja-alert-name" style="color:#7c4dff;">Marketing Manager</span>
          <span class="ja-alert-status active" style="background:rgba(124,77,255,0.10);color:#7c4dff;">Active</span>
        </div>
        <div class="ja-alert-details">
          <p><strong>Location:</strong> San Francisco</p>
          <p><strong>Experience:</strong> Senior Level</p>
          <p><strong>Frequency:</strong> Weekly</p>
        </div>
        <div class="ja-alert-actions">
          <button class="ja-action-btn edit" style="background:rgba(124,77,255,0.10);color:#7c4dff;">Edit</button>
          <button class="ja-action-btn delete">Delete</button>
        </div>
      </div>
      
      <div class="ja-alert-card">
        <div class="ja-alert-header">
          <span class="ja-alert-name" style="color:#7c4dff;">Data Analyst</span>
          <span class="ja-alert-status inactive">Inactive</span>
        </div>
        <div class="ja-alert-details">
          <p><strong>Location:</strong> Chicago</p>
          <p><strong>Experience:</strong> Entry Level</p>
          <p><strong>Frequency:</strong> Daily</p>
        </div>
        <div class="ja-alert-actions">
          <button class="ja-action-btn edit" style="background:rgba(124,77,255,0.10);color:#7c4dff;">Edit</button>
          <button class="ja-action-btn delete">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Features Section -->
<div class="ja-features-section">
  <div class="ja-features-container">
    <h2 class="ja-features-title">Why Use Job Alerts?</h2>
    <div class="ja-features-grid">
      <div class="ja-feature-card">
        <div class="ja-feature-icon">
          <!-- Clock SVG -->
          <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28" cy="28" r="24" fill="#b388ff"/>
            <path d="M28 16v12l8 8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="28" cy="28" r="18" stroke="#fff" stroke-width="2.5" fill="none"/>
          </svg>
        </div>
        <h3>Save Time</h3>
        <p>No more manually searching for jobs. Get relevant opportunities delivered to your inbox automatically.</p>
      </div>
      
      <div class="ja-feature-card">
        <div class="ja-feature-icon">
          <!-- Target SVG -->
          <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28" cy="28" r="24" fill="#b388ff"/>
            <circle cx="28" cy="28" r="14" stroke="#fff" stroke-width="2.5" fill="none"/>
            <circle cx="28" cy="28" r="6" fill="#fff"/>
          </svg>
        </div>
        <h3>Precise Matching</h3>
        <p>Set specific criteria to receive only the most relevant job opportunities that match your skills and preferences.</p>
      </div>
      
      <div class="ja-feature-card">
        <div class="ja-feature-icon">
          <!-- Bell SVG -->
          <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28" cy="28" r="24" fill="#b388ff"/>
            <path d="M38 36V26a10 10 0 10-20 0v10l-2 4h24l-2-4z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <path d="M31 44a3 3 0 01-6 0" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          </svg>
        </div>
        <h3>Instant Notifications</h3>
        <p>Be among the first to know about new opportunities with instant or daily notifications.</p>
      </div>
      
      <div class="ja-feature-card">
        <div class="ja-feature-icon">
          <!-- Shield/Check SVG -->
          <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28" cy="28" r="24" fill="#b388ff"/>
            <path d="M28 12l14 8v10c0 10-7 18-14 18s-14-8-14-18V20l14-8z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <path d="M22 28l5 5 7-7" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          </svg>
        </div>
        <h3>Privacy Control</h3>
        <p>Manage your alerts with full control over your data and notification preferences.</p>
      </div>
    </div>
  </div>
</div>

<!-- Tips Section -->
<div class="ja-tips-section">
  <div class="ja-tips-container">
    <h2 class="ja-tips-title">Tips for Effective Job Alerts</h2>
    <div class="ja-tips-list">
      <div class="ja-tip-item">
        <div class="ja-tip-icon" style="color:#7c4dff;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#b388ff" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="ja-tip-content">
          <h4 style="color:#7c4dff;">Use Specific Keywords</h4>
          <p>Include exact job titles, skills, and technologies you're interested in to get more targeted results.</p>
        </div>
      </div>
      
      <div class="ja-tip-item">
        <div class="ja-tip-icon" style="color:#7c4dff;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#b388ff" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="ja-tip-content">
          <h4 style="color:#7c4dff;">Consider Multiple Locations</h4>
          <p>Set up alerts for different cities or remote opportunities to expand your job search scope.</p>
        </div>
      </div>
      
      <div class="ja-tip-item">
        <div class="ja-tip-icon" style="color:#7c4dff;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#b388ff" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="ja-tip-content">
          <h4 style="color:#7c4dff;">Adjust Frequency Wisely</h4>
          <p>Use instant alerts for urgent searches and weekly alerts for ongoing passive job hunting.</p>
        </div>
      </div>
      
      <div class="ja-tip-item">
        <div class="ja-tip-icon" style="color:#7c4dff;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#b388ff" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="ja-tip-content">
          <h4 style="color:#7c4dff;">Regularly Update Alerts</h4>
          <p>Review and update your alert criteria every few months to ensure they remain relevant to your career goals.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/main.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 