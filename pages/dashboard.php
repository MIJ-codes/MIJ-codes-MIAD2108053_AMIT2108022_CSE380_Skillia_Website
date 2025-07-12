<?php
session_start();
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

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $skills = trim($_POST['skills'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $education = trim($_POST['education'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    if ($profile) {
        // Update existing profile
        $stmt = $pdo->prepare('UPDATE job_seekers SET skills = ?, experience = ?, education = ?, location = ?, bio = ?, updated_at = NOW() WHERE user_id = ?');
        $stmt->execute([$skills, $experience, $education, $location, $bio, $user_id]);
    } else {
        // Create new profile
        $stmt = $pdo->prepare('INSERT INTO job_seekers (user_id, skills, experience, education, location, bio, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([$user_id, $skills, $experience, $education, $location, $bio]);
    }
    
    $message = 'Profile updated successfully!';
    
    // Refresh profile data
    $stmt = $pdo->prepare('SELECT * FROM job_seekers WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $profile = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Seeker Dashboard - Skillia</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
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
  </style>
  <script>
    function showTab(tab) {
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
      document.getElementById(tab+'-tab').classList.add('active');
      document.getElementById(tab+'-content').classList.add('active');
    }
    window.onload = function() { showTab('all'); };
  </script>
</head>
<body>
<div class="dashboard-container">
  <h2 style="color:#7c4dff;">Welcome, <?= htmlspecialchars($name) ?>!</h2>

  <?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <div class="section-title">Update Your Profile</div>
  <form class="profile-form" method="post">
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
    
    <button type="submit" name="update_profile">Update Profile</button>
  </form>

  <div class="section-title">My Applications</div>
  <div class="tab-content active" id="all-content">
    <?php if (empty($applications)): ?>
      <div style="padding:1.5rem; color:#888;">You have not applied to any jobs yet.</div>
    <?php else: ?>
      <table class="applications-table">
        <tr>
          <th>Job Title</th>
          <th>Company</th>
          <th>Location</th>
          <th>Salary</th>
          <th>Status</th>
          <th>Applied At</th>
        </tr>
        <?php foreach ($applications as $app): ?>
          <tr>
            <td><?= htmlspecialchars($app['title']) ?></td>
            <td><?= htmlspecialchars($app['company_name']) ?></td>
            <td><?= htmlspecialchars($app['location']) ?></td>
            <td><?= htmlspecialchars($app['salary']) ?></td>
            <td class="status-<?= htmlspecialchars($app['status']) ?>"><?= ucfirst($app['status']) ?></td>
            <td><?= date('M d, Y', strtotime($app['applied_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </div>

  <div class="section-title">Share Your Success Story</div>
  <form class="success-story-form">[Success story form placeholder]</form>

  <div class="section-title">Other Features</div>
  <ul>
    <li>Saved Jobs / Favorites (coming soon)</li>
    <li>Interview Schedule / Tracking (coming soon)</li>
    <li>Notifications / Messages (coming soon)</li>
    <li>Account Settings (coming soon)</li>
  </ul>
</div>
<?php include '../includes/footer.php'; ?>
<script src="../assets/js/main.js"></script>
</body>
</html> 