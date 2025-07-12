<?php $currentPage = 'salary-guide'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Salary Guide</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/salary-guide.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<?php include '../includes/header.php'; ?>

<!-- Hero Section -->
<div class="sg-hero-section">
  <div class="sg-hero-bg"></div>
  <div class="sg-hero-content">
    <h1 class="sg-hero-title" style="color:#fff;text-shadow:1px 1px 0 #ffd600,-1px -1px 0 #7c4dff;">Salary Guide</h1>
    <p class="sg-hero-subtitle" style="color:#7c4dff;">Plan your next move with up-to-date salary data and insights</p>
  </div>
  <div class="animated-coins">
    <span style="background:rgba(255,214,0,0.18);"></span>
    <span style="background:rgba(255,112,67,0.18);"></span>
    <span style="background:rgba(124,77,255,0.18);"></span>
    <span style="background:rgba(255,214,0,0.18);"></span>
    <span style="background:rgba(255,112,67,0.18);"></span>
  </div>
</div>

<!-- Calculator Section -->
<div class="sg-calculator-section">
  <div class="sg-calculator-container">
    <h2 class="sg-calculator-title" style="color:#ff7043;">Salary Calculator</h2>
    <form class="sg-calculator-form">
      <div class="sg-form-row">
        <div class="sg-form-group">
          <label for="job-title" style="color:#7c4dff;">Job Title</label>
          <input type="text" id="job-title" placeholder="e.g., Software Engineer, Marketing Manager">
        </div>
        <div class="sg-form-group">
          <label for="location" style="color:#7c4dff;">Location</label>
          <input type="text" id="location" placeholder="e.g., New York, San Francisco">
        </div>
      </div>
      <div class="sg-form-row">
        <div class="sg-form-group">
          <label for="experience" style="color:#7c4dff;">Years of Experience</label>
          <select id="experience">
            <option value="">Select Experience</option>
            <option value="0-1">0-1 years</option>
            <option value="2-4">2-4 years</option>
            <option value="5-7">5-7 years</option>
            <option value="8-10">8-10 years</option>
            <option value="10+">10+ years</option>
          </select>
        </div>
        <div class="sg-form-group">
          <label for="education" style="color:#7c4dff;">Education Level</label>
          <select id="education">
            <option value="">Select Education</option>
            <option value="high-school">High School</option>
            <option value="bachelors">Bachelor's Degree</option>
            <option value="masters">Master's Degree</option>
            <option value="phd">PhD</option>
          </select>
        </div>
      </div>
      <button type="submit" class="sg-calculate-btn" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);color:#fff;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#7c4dff" stroke-width="2" stroke-linecap="round"/></svg>
        Calculate Salary
      </button>
    </form>
    <div class="sg-result" style="display: none;">
      <h3 style="color:#ff7043;">Estimated Salary Range</h3>
      <div class="salary-amount" style="color:#ffd600;">$85,000 - $120,000</div>
      <div class="salary-range" style="color:#7c4dff;">Based on your criteria and current market data</div>
    </div>
  </div>
</div>

<!-- Market Section -->
<div class="sg-market-section">
  <div class="sg-market-container">
    <h2 class="sg-market-title" style="color:#ff7043;">Market Salary Data</h2>
    <div class="sg-market-grid">
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">Software Engineer</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$95,000</span>
          <span class="growth-rate positive" style="background:rgba(255,214,0,0.10);color:#ffd600;">+8.5%</span>
        </div>
        <p>High demand for skilled developers with expertise in modern technologies and frameworks.</p>
      </div>
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">Marketing Manager</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$78,000</span>
          <span class="growth-rate positive" style="background:rgba(255,214,0,0.10);color:#ffd600;">+6.2%</span>
        </div>
        <p>Digital marketing skills and data-driven decision making are highly valued in this role.</p>
      </div>
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">Data Analyst</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$72,000</span>
          <span class="growth-rate positive" style="background:rgba(255,214,0,0.10);color:#ffd600;">+12.3%</span>
        </div>
        <p>Rapidly growing field with increasing demand for data-driven insights across industries.</p>
      </div>
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">Product Manager</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$105,000</span>
          <span class="growth-rate positive" style="background:rgba(255,214,0,0.10);color:#ffd600;">+9.1%</span>
        </div>
        <p>Strategic role combining technical knowledge with business acumen and leadership skills.</p>
      </div>
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">UX Designer</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$82,000</span>
          <span class="growth-rate positive" style="background:rgba(255,214,0,0.10);color:#ffd600;">+7.8%</span>
        </div>
        <p>User experience design is critical for digital products and customer satisfaction.</p>
      </div>
      <div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">
        <h3 style="color:#ff7043;">Sales Representative</h3>
        <div class="salary-data">
          <span class="avg-salary" style="color:#ffd600;">$65,000</span>
          <span class="growth-rate negative" style="background:rgba(255,112,67,0.10);color:#ff7043;">-2.1%</span>
        </div>
        <p>Traditional sales roles are evolving with technology and automation changes.</p>
      </div>
    </div>
  </div>
</div>

<!-- Industries Section -->
<div class="sg-industries-section">
  <div class="sg-industries-container">
    <h2 class="sg-industries-title" style="color:#ff7043;">Salary by Industry</h2>
    <div class="sg-industries-grid">
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Technology</h3>
        <div class="salary-range" style="color:#ffd600;">$85K - $150K</div>
        <p>Highest paying industry with competitive benefits and stock options.</p>
      </div>
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Finance</h3>
        <div class="salary-range" style="color:#ffd600;">$75K - $130K</div>
        <p>Stable industry with good benefits and performance-based bonuses.</p>
      </div>
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Healthcare</h3>
        <div class="salary-range" style="color:#ffd600;">$70K - $120K</div>
        <p>Growing field with strong job security and meaningful work.</p>
      </div>
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Retail</h3>
        <div class="salary-range" style="color:#ffd600;">$45K - $85K</div>
        <p>Entry-level friendly with opportunities for advancement.</p>
      </div>
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Manufacturing</h3>
        <div class="salary-range" style="color:#ffd600;">$60K - $100K</div>
        <p>Stable industry with good benefits and union representation.</p>
      </div>
      <div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">
        <div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#ffd600" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h3 style="color:#ff7043;">Education</h3>
        <div class="salary-range" style="color:#ffd600;">$50K - $90K</div>
        <p>Meaningful work with summers off and strong job security.</p>
      </div>
    </div>
  </div>
</div>

<!-- Trends Section -->
<div class="sg-trends-section">
  <div class="sg-trends-container">
    <h2 class="sg-trends-title" style="color:#ff7043;">Salary Trends & Insights</h2>
    <div class="sg-trends-list">
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Remote Work Impact</h4>
          <p>Remote positions often offer competitive salaries while reducing living costs, making them highly attractive to job seekers.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Skills-Based Pay</h4>
          <p>Companies are increasingly valuing specific skills and certifications over traditional education requirements.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Geographic Variations</h4>
          <p>Salary ranges vary significantly by location, with tech hubs and major cities offering higher compensation.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Experience Premium</h4>
          <p>Experienced professionals can command 20-40% higher salaries than entry-level positions in the same field.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/main.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 