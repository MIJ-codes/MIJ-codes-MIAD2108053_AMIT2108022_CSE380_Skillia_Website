<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'jobseeker') {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';
include '../includes/header.php';

// Fetch user info
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT name FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$name = $user ? $user['name'] : 'Job Seeker';

// Fetch existing profile data
$stmt = $pdo->prepare('SELECT * FROM job_seekers WHERE user_id = ?');
$stmt->execute([$user_id]);
$profile = $stmt->fetch();

// Fetch applications for this job seeker
$applications = [];
if ($profile) {
    $seeker_id = $profile['id'];
    $stmt = $pdo->prepare('
        SELECT applications.*, jobs.title, jobs.location, jobs.salary, jobs.description, employers.company_name
        FROM applications
        JOIN jobs ON applications.job_id = jobs.id
        JOIN employers ON jobs.employer_id = employers.id
        WHERE applications.seeker_id = ?
        ORDER BY applications.applied_at DESC
    ');
    $stmt->execute([$seeker_id]);
    $applications = $stmt->fetchAll();
}

$message = '';
$message_story = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $skills = trim($_POST['skills'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $education = trim($_POST['education'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $portfolio = trim($_POST['portfolio'] ?? '');
    $photo_path = $profile['photo'] ?? null;
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $new_name = 'jobseeker_' . $user_id . '_' . time() . '.' . $ext;
        $target_dir = '../uploads/job-seeker-profile/';
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        $target_file = $target_dir . $new_name;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_path = $target_file;
        }
    }
    $github = trim($_POST['github'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $expected_salary = trim($_POST['expected_salary'] ?? '');
    $languages = trim($_POST['languages'] ?? '');
    if ($profile) {
        // Update existing profile
        $stmt = $pdo->prepare('UPDATE job_seekers SET skills = ?, experience = ?, education = ?, location = ?, bio = ?, phone = ?, linkedin = ?, portfolio = ?, photo = ?, title = ?, expected_salary = ?, languages = ?, github = ?, updated_at = NOW() WHERE user_id = ?');
        $stmt->execute([$skills, $experience, $education, $location, $bio, $phone, $linkedin, $portfolio, $photo_path, $title, $expected_salary, $languages, $github, $user_id]);
    } else {
        // Create new profile
        $stmt = $pdo->prepare('INSERT INTO job_seekers (user_id, skills, experience, education, location, bio, phone, linkedin, portfolio, photo, title, expected_salary, languages, github, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([$user_id, $skills, $experience, $education, $location, $bio, $phone, $linkedin, $portfolio, $photo_path, $title, $expected_salary, $languages, $github]);
    }
    $message = 'Profile updated successfully!';
    // Refresh profile data
    $stmt = $pdo->prepare('SELECT * FROM job_seekers WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $profile = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['story_name'])) {
  $story_name = trim($_POST['story_name'] ?? '');
  $story_job_title = trim($_POST['story_job_title'] ?? '');
  $story_company = trim($_POST['story_company'] ?? '');
  $story_text = trim($_POST['story_text'] ?? '');
  $story_photo_url = null;
  if (isset($_FILES['story_photo']) && $_FILES['story_photo']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['story_photo']['name'], PATHINFO_EXTENSION);
    $new_name = 'story_' . time() . '_' . rand(1000,9999) . '.' . $ext;
    $target_dir = '../uploads/success-stories/';
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    $target_file = $target_dir . $new_name;
    if (move_uploaded_file($_FILES['story_photo']['tmp_name'], $target_file)) {
      $story_photo_url = $target_file;
    }
  }
  if ($story_name && $story_job_title && $story_company && $story_text) {
    $stmt = $pdo->prepare('INSERT INTO success_stories (name, job_title, company, story, image_url) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$story_name, $story_job_title, $story_company, $story_text, $story_photo_url]);
    $message_story = 'Thank you for sharing your success story!';
  } else {
    $message_story = 'Please fill in all required fields.';
  }
}

// Handle clear actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear_applications'])) {
        if ($seeker_id) {
            $stmt = $pdo->prepare('DELETE FROM applications WHERE seeker_id = ?');
            $stmt->execute([$seeker_id]);
            $applications = [];
            $message = 'All applications cleared.';
        }
    } elseif (isset($_POST['clear_interviews'])) {
        if ($seeker_id) {
            $stmt = $pdo->prepare('DELETE FROM interviews WHERE job_seeker_id = ?');
            $stmt->execute([$seeker_id]);
            $interviews = [];
            $interviews_count = 0;
            $message = 'All interviews cleared.';
        }
    } elseif (isset($_POST['clear_notifications'])) {
        if ($seeker_id) {
            $stmt = $pdo->prepare('DELETE FROM notifications WHERE user_id = ? AND user_type = ?');
            $stmt->execute([$seeker_id, 'job_seeker']);
            $notifications = [];
            $notifications_count = 0;
            $message = 'All notifications cleared.';
        }
    }
}

// Calculate profile completeness in PHP
$fields = ['skills','experience','education','location','bio','phone','linkedin','portfolio','title','expected_salary','languages','github'];
$filled = 0;
foreach ($fields as $f) if (!empty($profile[$f])) $filled++;
$profile_percent = round($filled / count($fields) * 100);

// Fetch interviews for this job seeker
$interviews = [];
if (isset($seeker_id)) {
    $stmt = $pdo->prepare('SELECT i.*, j.title as job_title, e.company_name FROM interviews i JOIN jobs j ON i.job_id = j.id JOIN employers e ON j.employer_id = e.id WHERE i.job_seeker_id = ? ORDER BY i.interview_date DESC, i.interview_time DESC');
    $stmt->execute([$seeker_id]);
    $interviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Fetch notifications for this job seeker
$notifications = [];
if (isset($seeker_id)) {
    $stmt = $pdo->prepare('SELECT * FROM notifications WHERE user_id = ? AND user_type = ? ORDER BY created_at DESC LIMIT 20');
    $stmt->execute([$seeker_id, 'job_seeker']);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Seeker Dashboard - Skillia</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/dashboard-jobseeker.css">
  <style>
    .dashboard-container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px #b39ddb33; padding: 32px; }
    .tabs { display: flex; gap: 16px; margin-bottom: 18px; }
    .tab-btn { padding: 8px 24px; border: none; background: #ede7f6; color: #7c4dff; border-radius: 8px 8px 0 0; font-weight: 600; cursor: pointer; }
    .tab-btn.active { background: #7c4dff; color: #fff; }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .section-title { color: #7c4dff; margin-top: 32px; margin-bottom: 12px; }
    .success-story-form textarea { width: 100%; min-height: 80px; border-radius: 8px; border: 1px solid #b39ddb; padding: 8px; }
    .success-story-form button { background: #7c4dff; color: #fff; border: none; border-radius: 8px; padding: 8px 24px; margin-top: 8px; }
    .profile-form { background: #f8f5ff; padding: 20px; border-radius: 12px; margin-bottom: 24px; }
    .profile-form label { display: block; margin-bottom: 6px; color: #6c3fc5; font-weight: 600; }
    .profile-form input, .profile-form textarea { width: 100%; padding: 10px; border: 1px solid #d1c4e9; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
    .profile-form textarea { min-height: 80px; resize: vertical; }
    .profile-form button { background: #6c3fc5; color: #fff; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; cursor: pointer; }
    .profile-form button:hover { background: #5e35b1; }
    .message { background: #e8f5e8; color: #2e7d32; padding: 12px; border-radius: 6px; margin-bottom: 16px; text-align: center; }
    .applications-table { width: 100%; border-collapse: collapse; margin-top: 18px; background: #faf8ff; border-radius: 10px; overflow: hidden; }
    .applications-table th, .applications-table td { padding: 12px 10px; text-align: left; }
    .applications-table th { background: #ede7f6; color: #512da8; font-weight: 600; }
    .applications-table tr:not(:last-child) { border-bottom: 1px solid #e0d7f7; }
    .applications-table td.status-pending { color: #b39ddb; font-weight: 600; }
    .applications-table td.status-accepted { color: #2e7d32; font-weight: 600; }
    .applications-table td.status-rejected { color: #d32f2f; font-weight: 600; }
    .empty-state { text-align: center; padding: 2rem; color: #888; }
    .empty-state i { font-size: 4rem; margin-bottom: 10px; }
    .empty-state h3 { margin-bottom: 5px; }
    .empty-state p { font-size: 0.9rem; }
    .status-badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.85rem;
    }
    .status-badge.status-pending { background-color: #f3e5f5; color: #c62828; }
    .status-badge.status-accepted { background-color: #e8f5e9; color: #2e7d32; }
    .status-badge.status-rejected { background-color: #ffebee; color: #d32f2f; }
    .features-list { list-style: none; padding: 0; margin-top: 18px; }
    .features-list li {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
      padding: 10px 15px;
      background: #f0f7fa;
      border-radius: 10px;
      border: 1px solid #d0e9ff;
    }
    .features-list li i {
      font-size: 1.5rem;
      margin-right: 10px;
      color: #7c4dff;
    }
    .features-list li span {
      flex-grow: 1;
      font-weight: 600;
      color: #333;
    }
    .features-list li .coming-soon {
      font-size: 0.8rem;
      color: #888;
      margin-left: 10px;
    }
    .progress-bar-bg {
      width: 100%;
      height: 10px;
      background: #f3e5f5;
      border-radius: 8px;
      margin-top: 6px;
      overflow: hidden;
    }
    .progress-bar-fill {
      height: 100%;
      border-radius: 8px;
      background: linear-gradient(90deg, #ff512f 0%, #ffb347 60%, #ffe259 100%);
      /* reddish orange to yellow-gold */
      transition: width 0.6s cubic-bezier(.4,2,.3,1);
    }
    .clear-btn {
      background: linear-gradient(90deg, #ff512f 0%, #ffb347 60%, #ffe259 100%);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 6px 18px;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      box-shadow: 0 2px 8px #ffb34733;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: background 0.3s, box-shadow 0.3s, transform 0.2s;
    }
    .clear-btn:hover {
      background: linear-gradient(90deg, #ff512f 0%, #ffe259 100%);
      box-shadow: 0 4px 16px #ffb34755;
      transform: translateY(-2px) scale(1.04);
    }
    .status-badge.status-scheduled {
      background-color: #fffde7;
      color: #f9a825;
      border: 1px solid #ffe082;
    }
  </style>
  <script>
    function showTab(tab) {
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
      document.getElementById(tab+'-tab').classList.add('active');
      document.getElementById(tab+'-content').classList.add('active');
    }
    // Remove JS profile completeness calculation, only keep tab logic
    function calcProfileCompleteness() {
      let filled = 0, total = 12;
      <?php
        $fields = ['skills','experience','education','location','bio','phone','linkedin','portfolio','title','expected_salary','languages','github'];
        $filled = 0;
        foreach ($fields as $f) if (!empty($profile[$f])) $filled++;
      ?>
      let percent = Math.round(<?= $filled ?> / total * 100);
      document.getElementById('profile-completeness').innerText = percent + '%';
      document.getElementById('profile-progress-bar').style.width = percent + '%';
    }
    window.onload = function() { showTab('all'); calcProfileCompleteness(); };
  </script>
</head>
<body>
<div class="dashboard-container">
  <div class="dashboard-header">
    <div class="dashboard-title">Welcome, <?= htmlspecialchars($name) ?>!</div>
  </div>
  <?php
// Get the logged-in user's user_id
$user_id = $_SESSION['user_id'];
// Fetch the corresponding job_seeker id
$stmt = $pdo->prepare('SELECT id FROM job_seekers WHERE user_id = ?');
$stmt->execute([$user_id]);
$seeker_id = $stmt->fetchColumn();
// Fetch counts for dashboard cards
$applications_count = 0;
$interviews_count = 0;
$notifications_count = 0;
if ($seeker_id) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM applications WHERE seeker_id = ?');
    $stmt->execute([$seeker_id]);
    $applications_count = $stmt->fetchColumn();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM interviews WHERE job_seeker_id = ?');
    $stmt->execute([$seeker_id]);
    $interviews_count = $stmt->fetchColumn();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ? AND user_type = ?');
    $stmt->execute([$user_id, 'job_seeker']);
    $notifications_count = $stmt->fetchColumn();
}
?>
<div class="dashboard-stats">
    <div class="stat-card">
        <i class="ri-briefcase-line"></i>
        <div class="stat-value"><?= $applications_count ?></div>
        <div class="stat-label">Applications</div>
    </div>
    <div class="stat-card">
        <i class="ri-calendar-check-line"></i>
        <div class="stat-value"><?= $interviews_count ?></div>
        <div class="stat-label">Interviews</div>
    </div>
    <div class="stat-card">
        <i class="ri-notification-3-line"></i>
        <div class="stat-value"><?= $notifications_count ?></div>
        <div class="stat-label">Notifications</div>
    </div>
    <div class="stat-card">
        <i class="ri-user-star-line"></i>
        <div class="stat-value"><?= $profile_percent ?>%</div>
        <div class="stat-label">Profile Complete</div>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: <?= $profile_percent ?>%"></div>
        </div>
    </div>
</div>

  <?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <div class="section-title">Update Your Profile</div>
  <form class="profile-form" method="post" enctype="multipart/form-data">
    <div class="profile-photo-wrapper">
      <input type="file" name="photo" id="photo-upload" accept="image/*" style="display:none;" onchange="this.form.submit()">
      <label for="photo-upload" class="profile-photo-label">
        <?php if (!empty($profile['photo'])): ?>
          <img src="<?= htmlspecialchars($profile['photo']) ?>" alt="Profile Photo" class="profile-photo">
        <?php else: ?>
          <div class="profile-photo-placeholder"><i class="ri-user-3-line"></i></div>
        <?php endif; ?>
        <span class="edit-photo-overlay"><i class="ri-camera-line"></i></span>
      </label>
    </div>
    <label>Skills (e.g., PHP, JavaScript, Project Management)</label>
    <input type="text" name="skills" value="<?= htmlspecialchars($profile['skills'] ?? '') ?>" placeholder="Enter your key skills">
    
    <label>Experience (e.g., 3 years in web development)</label>
    <input type="text" name="experience" value="<?= htmlspecialchars($profile['experience'] ?? '') ?>" placeholder="Describe your experience">
    
    <label>Education</label>
    <input type="text" name="education" value="<?= htmlspecialchars($profile['education'] ?? '') ?>" placeholder="Your educational background">
    
    <label>Location</label>
    <input type="text" name="location" value="<?= htmlspecialchars($profile['location'] ?? '') ?>" placeholder="City, Country">
    
    <label>Bio/About Me</label>
    <textarea name="bio" placeholder="Tell employers about yourself, your goals, and what you're looking for..."><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
    
    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" placeholder="Your phone number">
    <label>LinkedIn</label>
    <input type="url" name="linkedin" value="<?= htmlspecialchars($profile['linkedin'] ?? '') ?>" placeholder="LinkedIn profile URL">
    <label>Portfolio</label>
    <input type="url" name="portfolio" value="<?= htmlspecialchars($profile['portfolio'] ?? '') ?>" placeholder="Portfolio website (optional)">
    
    <label>Professional Title (e.g., Senior Web Developer)</label>
    <input type="text" name="title" value="<?= htmlspecialchars($profile['title'] ?? '') ?>" placeholder="Your professional headline">
    <label>Expected Salary</label>
    <input type="text" name="expected_salary" value="<?= htmlspecialchars($profile['expected_salary'] ?? '') ?>" placeholder="e.g., 50,000 BDT/month">
    <label>Languages Spoken</label>
    <input type="text" name="languages" value="<?= htmlspecialchars($profile['languages'] ?? '') ?>" placeholder="e.g., English, Bengali, Hindi">
    <label>GitHub</label>
    <input type="url" name="github" value="<?= htmlspecialchars($profile['github'] ?? '') ?>" placeholder="GitHub profile URL">
    
    <button type="submit" name="update_profile">Update Profile</button>
  </form>

  <div class="section-title" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
    <span>My Applications</span>
    <form method="post" style="margin:0;">
      <button type="submit" name="clear_applications" class="clear-btn" id="clear-applications-btn"><i class="ri-delete-bin-6-line"></i> Clear</button>
    </form>
  </div>
<div id="all-content">
  <?php if (isset($applications) && count($applications) > 0): ?>
    <table class="applications-table">
      <tr>
        <th>Job Title</th>
        <th>Company</th>
        <th>Location</th>
        <th>Salary</th>
        <th>Status</th>
        <th>Applied At</th>
      </tr>
      <?php
      // Build a lookup of scheduled interviews by job_id for this seeker
      $scheduled_interviews = [];
      foreach ($interviews as $iv) {
          if (strtolower($iv['status']) === 'scheduled') {
              $scheduled_interviews[$iv['job_id']] = true;
          }
      }
      ?>
      <?php foreach ($applications as $app): ?>
        <tr>
          <td><?= htmlspecialchars($app['title']) ?></td>
          <td><?= htmlspecialchars($app['company_name']) ?></td>
          <td><?= htmlspecialchars($app['location']) ?></td>
          <td><?= htmlspecialchars($app['salary']) ?></td>
          <td>
            <?php if (isset($scheduled_interviews[$app['job_id']])): ?>
              <span class="status-badge status-scheduled">Scheduled</span>
            <?php else: ?>
              <span class="status-badge status-<?= htmlspecialchars($app['status']) ?>"><?= ucfirst($app['status']) ?></span>
            <?php endif; ?>
          </td>
          <td><?= date('M d, Y', strtotime($app['applied_at'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <div class="empty-state"><i class="ri-inbox-line"></i><h3>No Applications Yet</h3><p>You have not applied to any jobs yet.</p></div>
  <?php endif; ?>
</div>

  <div class="section-title" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
    <span>Interview Schedule / Tracking</span>
    <form method="post" style="margin:0;">
      <button type="submit" name="clear_interviews" class="clear-btn" id="clear-interviews-btn"><i class="ri-delete-bin-6-line"></i> Clear</button>
    </form>
  </div>
<div class="interviews-section">
  <?php if (isset($interviews) && count($interviews) > 0): ?>
    <table class="applications-table">
      <tr>
        <th>Job Title</th>
        <th>Company</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <!-- Removed Status column header -->
      </tr>
      <?php foreach ($interviews as $iv): ?>
        <tr>
          <td><?= htmlspecialchars($iv['job_title']) ?></td>
          <td><?= htmlspecialchars($iv['company_name']) ?></td>
          <td><?= htmlspecialchars($iv['interview_date']) ?></td>
          <td><?= htmlspecialchars(substr($iv['interview_time'], 0, 5)) ?></td>
          <td><?= htmlspecialchars($iv['location_medium']) ?></td>
          <!-- Removed Status column cell -->
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <div class="empty-state">No interviews scheduled yet.</div>
  <?php endif; ?>
</div>
<div class="section-title" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
  <span>Notifications / Messages</span>
  <form method="post" style="margin:0;">
    <button type="submit" name="clear_notifications" class="clear-btn" id="clear-notifications-btn"><i class="ri-delete-bin-6-line"></i> Clear</button>
  </form>
</div>
<?php if (empty($notifications)): ?>
  <div class="empty-state"><i class="ri-notification-3-line"></i><h3>No Notifications</h3><p>You'll see important updates and messages here.</p></div>
<?php else: ?>
  <ul class="features-list">
    <?php foreach ($notifications as $note): ?>
      <li>
        <i class="ri-notification-3-line"></i>
        <span><strong><?= htmlspecialchars($note['title']) ?>:</strong> <?= htmlspecialchars($note['message']) ?> <small style="color:#888;">(<?= date('M d, Y H:i', strtotime($note['created_at'])) ?>)</small></span>
        <?php if (!$note['is_read']): ?><span class="coming-soon" style="color:#7c4dff;">New</span><?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

  <div class="section-title">Share Your Success Story</div>
  <?php if ($message_story): ?>
    <div class="message"> <?= htmlspecialchars($message_story) ?> </div>
  <?php endif; ?>
  <form class="success-story-form" method="post" enctype="multipart/form-data">
    <label>Your Name</label>
    <input type="text" name="story_name" placeholder="Enter your name" required>
    <label>Job Title</label>
    <input type="text" name="story_job_title" placeholder="e.g. Web Developer" required>
    <label>Company</label>
    <input type="text" name="story_company" placeholder="e.g. Skillia" required>
    <label>Your Story</label>
    <textarea name="story_text" placeholder="Share your experience..." required></textarea>
    <label>Photo (optional)</label>
    <input type="file" name="story_photo" accept="image/*">
    <button type="submit">Submit Story</button>
  </form>

</div>
<?php include '../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html> 