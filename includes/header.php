<?php 
/* Skillia Header Include */ 
?>
<?php $currentPage = isset($currentPage) ? $currentPage : '' ?>
<div id="header">
  <div id="logo">
    <div id="favicon">
      <img src="/Skillia/assets/images/Skillia_Logo.png" alt="Skillia Logo" />
    </div>
    <div id="name"><p>Skillia</p></div>
  </div>
  <div class="writing">
    <div id="home"<?php if($currentPage=='home') echo ' class="selected"'; ?>>
      <a href="/Skillia/pages/home.php"><p>Home</p></a>
    </div>
    <div id="jobboard"<?php if($currentPage=='job-board') echo ' class="selected"'; ?>>
      <a href="/Skillia/pages/job-board.php"><p>Job Board</p></a>
    </div>
    <div id="categories"<?php if($currentPage=='categories') echo ' class="selected"'; ?>>
      <a href="/Skillia/pages/categories.php"><p>Categories</p></a>
    </div>
    <div id="aboutus"<?php if($currentPage=='about-us') echo ' class="selected"'; ?>>
      <a href="/Skillia/pages/about-us.php"><p>About Us</p></a>
    </div>
    <div id="explore" class="dropdown">
      <div class="dropdown-trigger">
        <i class="ri-compass-3-line"></i>
        <p>Explore</p>
        <i class="ri-arrow-down-s-line dropdown-arrow"></i>
      </div>
      <div class="dropdown-menu">
        <a href="/Skillia/pages/job-seekers.php" class="dropdown-item">
          <i class="ri-user-search-line"></i>
          <span>For Job Seekers</span>
        </a>
        <a href="/Skillia/pages/for-employers.php" class="dropdown-item">
          <i class="ri-building-line"></i>
          <span>For Employers</span>
        </a>
        <a href="/Skillia/pages/company.php" class="dropdown-item">
          <i class="ri-briefcase-line"></i>
          <span>Company</span>
        </a>
      </div>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div id="dashboard"<?php if($currentPage=='dashboard' || $currentPage=='employer-dashboard') echo ' class="selected"'; ?>>
        <a href="/Skillia/pages/<?php echo $_SESSION['user_type'] === 'employer' ? 'employer-dashboard.php' : 'job-seeker-dashboard.php'; ?>"><p>Dashboard</p></a>
      </div>
      <div id="logout">
        <a href="/Skillia/pages/logout.php"><p>Logout</p></a>
      </div>
    <?php else: ?>
      <div id="login"<?php if($currentPage=='login') echo ' class="selected"'; ?>>
        <a href="/Skillia/pages/login.php"><p>Login</p></a>
      </div>
    <?php endif; ?>
  </div>
</div>
<div id="fakeheader"></div> 