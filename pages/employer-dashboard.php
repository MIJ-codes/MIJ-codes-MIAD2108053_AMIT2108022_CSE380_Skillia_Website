<?php
session_start();
require_once '../includes/db.php';

// Access control: Only logged-in employers can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header('Location: login.php');
    exit();
}

// Fetch user info
$user_id = $_SESSION['user_id'];
$userName = '';
$userEmail = '';
$personalMessage = '';
try {
    $stmt = $pdo->prepare('SELECT name, email FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $userName = $user['name'];
        $userEmail = $user['email'];
    }
} catch (Exception $e) {}

// Fetch employer/company info
$companyName = '';
$companyDescription = '';
$companyLogo = '';
$employerPhone = '';
$employerPosition = '';
$employerPhoto = '';
$employer_id = null;
$profileMessage = '';
try {
    $stmt = $pdo->prepare('SELECT id, company_name, company_description, company_logo, phone, position, photo FROM employers WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $companyName = $row['company_name'];
        $companyDescription = $row['company_description'];
        $companyLogo = $row['company_logo'];
        $employerPhone = $row['phone'];
        $employerPosition = $row['position'];
        $employerPhoto = $row['photo'];
        $employer_id = $row['id'];
    }
} catch (Exception $e) {}

// Handle personal profile update
if (isset($_POST['update_personal']) && $employer_id) {
    $newName = trim($_POST['name'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $newPhone = trim($_POST['phone'] ?? '');
    $newPosition = trim($_POST['position'] ?? '');
    $newPhoto = $employerPhoto;
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $target = '../assets/images/employer_' . $employer_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $newPhoto = $target;
            }
        }
    }
    // Update users table (name/email)
    $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
    $stmt->execute([$newName, $newEmail, $user_id]);
    // Update employers table (phone, position, photo)
    $stmt = $pdo->prepare('UPDATE employers SET phone = ?, position = ?, photo = ? WHERE id = ?');
    $stmt->execute([$newPhone, $newPosition, $newPhoto, $employer_id]);
    $personalMessage = 'Personal profile updated!';
    $userName = $newName;
    $userEmail = $newEmail;
    $employerPhone = $newPhone;
    $employerPosition = $newPosition;
    $employerPhoto = $newPhoto;
}

// Handle password update
if (isset($_POST['update_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    if ($row && password_verify($current, $row['password'])) {
        if ($new && $new === $confirm) {
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->execute([password_hash($new, PASSWORD_DEFAULT), $user_id]);
            $personalMessage = 'Password updated!';
        } else {
            $personalMessage = 'New passwords do not match.';
        }
    } else {
        $personalMessage = 'Current password is incorrect.';
    }
}

// Handle company profile update
if (isset($_POST['update_profile']) && $employer_id) {
    $newName = trim($_POST['company_name'] ?? '');
    $newDesc = trim($_POST['company_description'] ?? '');
    $newLogo = $companyLogo;
    // Handle logo upload
    if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $target = '../assets/images/company_' . $employer_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $target)) {
                $newLogo = $target;
            }
        }
    }
    $stmt = $pdo->prepare('UPDATE employers SET company_name = ?, company_description = ?, company_logo = ? WHERE id = ?');
    $stmt->execute([$newName, $newDesc, $newLogo, $employer_id]);
    $profileMessage = 'Company profile updated!';
    $companyName = $newName;
    $companyDescription = $newDesc;
    $companyLogo = $newLogo;
}

// Handle job deletion
if (isset($_POST['delete_job_id']) && $employer_id) {
    $job_id = (int)$_POST['delete_job_id'];
    // Delete applications for this job
    $stmt = $pdo->prepare('DELETE FROM applications WHERE job_id = ?');
    $stmt->execute([$job_id]);
    // Now delete the job
    $stmt = $pdo->prepare('DELETE FROM jobs WHERE id = ? AND employer_id = ?');
    $stmt->execute([$job_id, $employer_id]);
    header('Location: employer-dashboard.php?delete=success');
    exit;
}

// Fetch jobs posted by this employer
$jobs = [];
if ($employer_id) {
    $stmt = $pdo->prepare('SELECT * FROM jobs WHERE employer_id = ? ORDER BY created_at DESC');
    $stmt->execute([$employer_id]);
    $jobs = $stmt->fetchAll();
}

// Fetch applicants for each job
$jobApplicants = [];
if (!empty($jobs)) {
    foreach ($jobs as $job) {
        $stmt = $pdo->prepare('SELECT a.*, js.user_id, u.name, u.email FROM applications a JOIN job_seekers js ON a.seeker_id = js.id JOIN users u ON js.user_id = u.id WHERE a.job_id = ? ORDER BY a.applied_at DESC');
        $stmt->execute([$job['id']]);
        $jobApplicants[$job['id']] = $stmt->fetchAll();
    }
}

include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Dashboard - Skillia</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    .dashboard-container {
        max-width: 1300px;
        margin: 40px auto;
        background: #f7f6ff;
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(81,45,168,0.10);
        padding: 40px 36px;
        text-align: center;
        animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: none; }
    }
    .profile-card {
        max-width: 420px;
        margin: 0 auto 32px auto;
        background: linear-gradient(135deg, #ede7f6 0%, #fff 100%);
        border-radius: 22px;
        box-shadow: 0 4px 24px #b39ddb33;
        padding: 36px 32px 28px 32px;
        position: relative;
        animation: fadeIn 1.2s cubic-bezier(.23,1.01,.32,1);
    }
    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #512da8;
        box-shadow: 0 2px 12px #b39ddb33;
        margin: 0 auto 18px auto;
        display: block;
        background: #faf8ff;
        transition: box-shadow 0.3s, border-color 0.3s;
        cursor: pointer;
        position: relative;
    }
    .profile-avatar:hover {
        box-shadow: 0 6px 24px #512da855;
        border-color: #7c4dff;
    }
    .profile-avatar-upload {
        position: absolute;
        left: 50%;
        top: 80px;
        transform: translateX(-50%);
        background: #512da8;
        color: #fff;
        border-radius: 16px;
        padding: 2px 12px;
        font-size: 0.95rem;
        opacity: 0.92;
        cursor: pointer;
        transition: background 0.2s;
        z-index: 2;
    }
    .profile-avatar-upload:hover {
        background: #7c4dff;
    }
    .profile-form {
        margin-top: 18px;
        text-align: left;
        animation: fadeIn 1.2s cubic-bezier(.23,1.01,.32,1);
    }
    .profile-form label {
        font-weight: 600;
        color: #512da8;
        margin-bottom: 4px;
        display: block;
        font-size: 1.05rem;
    }
    .profile-form input[type="text"], .profile-form input[type="email"], .profile-form input[type="password"], .profile-form textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #d1c4e9;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 1rem;
        background: #faf8ff;
        transition: border-color 0.2s;
    }
    .profile-form input:focus, .profile-form textarea:focus {
        border-color: #512da8;
        outline: none;
    }
    .profile-form textarea { min-height: 60px; resize: vertical; }
    .profile-form button {
        background: linear-gradient(90deg, #512da8 0%, #7c4dff 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 28px;
        font-weight: 600;
        font-size: 1.08rem;
        cursor: pointer;
        margin-top: 8px;
        margin-left: auto;
        margin-right: auto;
        display: block; /* Center the button */
        box-shadow: 0 2px 8px #b39ddb22;
        transition: background 0.2s, transform 0.2s, box-shadow 0.3s;
        animation: fadeIn 1.3s cubic-bezier(.23,1.01,.32,1);
        margin-bottom: 38px; /* Add more space below the button */
    }
    .profile-form button:hover {
        background: linear-gradient(90deg, #7c4dff 0%, #512da8 100%);
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 4px 16px #b39ddb44;
    }
    .profile-form .section-divider {
        margin: 40px 0 28px 0; /* More space above Change Password */
        border-top: 1.5px solid #e0e0e0;
    }
    .profile-message {
        background:#e8f5e8;color:#2e7d32;padding:12px;border-radius:6px;margin-bottom:18px;max-width:600px;text-align:center;
        animation: fadeIn 1.1s cubic-bezier(.23,1.01,.32,1);
    }
    .dashboard-info-card {
        background: #f7f4ff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(120, 80, 200, 0.08);
        padding: 40px 36px;
        margin: 32px auto 0 auto;
        max-width: 1100px;
        text-align: center;
        color: #4b2aad;
        font-size: 1.15rem;
        animation: fadeInUp 0.7s cubic-bezier(.23,1.01,.32,1) both;
        transition: box-shadow 0.3s;
    }
    .dashboard-info-card h2 {
        color: #4b2aad;
        margin-bottom: 12px;
        font-size: 1.4rem;
        font-weight: 700;
    }
    .dashboard-info-card p {
        color: #4b2aad;
        font-size: 1.08rem;
        margin-bottom: 0;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px);}
        to { opacity: 1; transform: translateY(0);}
    }
    /* Style for job posting and action buttons */
    .post-job-btn, .job-action-btn {
        display: inline-block;
        background: linear-gradient(90deg, #512da8 0%, #7c4dff 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 1rem;
        margin: 8px 4px;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s, box-shadow 0.3s;
        box-shadow: 0 2px 8px #b39ddb22;
    }
    .post-job-btn:hover, .job-action-btn:hover {
        background: linear-gradient(90deg, #7c4dff 0%, #512da8 100%);
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 4px 16px #b39ddb44;
    }
    .company-logo-preview {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 18px;
        border: 2.5px solid #7c4dff;
        box-shadow: 0 2px 12px #b39ddb33;
        margin: 0 auto 18px auto;
        display: block;
        background: #faf8ff;
        transition: box-shadow 0.3s, border-color 0.3s;
    }
    .company-logo-preview:hover {
        box-shadow: 0 6px 24px #512da855;
        border-color: #512da8;
    }
    .job-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 18px;
        margin-top: 24px;
    }
    .job-table th, .job-table td {
        padding: 18px 18px;
        text-align: left;
        background: none;
        border: none;
    }
    .job-table tr {
        background: #f9f7ff;
        border-radius: 16px;
        box-shadow: 0 2px 12px #b39ddb22;
        transition: box-shadow 0.2s, transform 0.18s;
    }
    .job-table tr:hover {
        box-shadow: 0 6px 24px #b39ddb44;
        transform: translateY(-2px) scale(1.01);
    }
    .job-table th {
        background: none;
        color: #2d1e4a;
        font-size: 1.08rem;
        font-weight: 700;
        border-bottom: none;
    }
    .job-table td {
        font-size: 1.04rem;
        color: #3d2c5a;
        vertical-align: middle;
    }
    .job-action-btn {
        margin-right: 10px;
        margin-bottom: 6px;
    }
    .job-action-btn:last-child {
        margin-right: 0;
    }
    @media (max-width: 900px) {
        .job-table th, .job-table td {
            padding: 10px 6px;
            font-size: 0.98rem;
        }
    }
    @media (max-width: 600px) {
      .profile-card { padding: 18px 6px; }
      .dashboard-container { padding: 10px; }
    }
    /* Add applicant card styles */
    .applicant-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px #b39ddb22;
        padding: 22px 20px 16px 20px;
        min-width: 260px;
        max-width: 320px;
        flex: 1 1 260px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.22s, transform 0.18s;
        border: 1.5px solid #ede7f6;
        margin-bottom: 8px;
        animation: fadeInUp 0.7s cubic-bezier(.23,1.01,.32,1) both;
    }
    .applicant-card:hover {
        box-shadow: 0 6px 24px #b39ddb44;
        transform: translateY(-2px) scale(1.01);
        border-color: #7c4dff;
    }
    .applicant-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .applicant-name {
        font-weight: 700;
        color: #512da8;
        font-size: 1.08rem;
    }
    .applicant-status {
        font-size: 0.98rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 8px;
        background: #ede7f6;
        color: #4b2aad;
        margin-left: 8px;
    }
    .status-accepted { background: #e8f5e9; color: #2e7d32; }
    .status-rejected { background: #ffebee; color: #c62828; }
    .status-pending { background: #fffde7; color: #f9a825; }
    .applicant-card-body {
        margin-bottom: 10px;
        color: #3d2c5a;
        font-size: 0.98rem;
    }
    .applicant-card-footer {
        margin-top: 8px;
        text-align: right;
    }
    .view-profile-btn {
        background: linear-gradient(90deg, #512da8 0%, #7c4dff 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 7px 18px;
        font-weight: 600;
        font-size: 0.98rem;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s, box-shadow 0.3s;
        box-shadow: 0 2px 8px #b39ddb22;
    }
    .view-profile-btn:hover {
        background: linear-gradient(90deg, #7c4dff 0%, #512da8 100%);
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 4px 16px #b39ddb44;
    }
    .custom-modal {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(81,45,168,0.13);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: fadeIn 0.2s;
    }
    .custom-modal-content {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(81,45,168,0.18);
      padding: 36px 32px 28px 32px;
      min-width: 320px;
      max-width: 90vw;
      text-align: center;
      animation: fadeInUp 0.3s cubic-bezier(.23,1.01,.32,1);
    }
    .custom-modal-message {
      font-size: 1.13rem;
      color: #512da8;
      margin-bottom: 28px;
      font-weight: 600;
    }
    .custom-modal-actions {
      display: flex;
      justify-content: center;
      gap: 24px;
    }
    .custom-modal-btn {
      padding: 10px 28px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1.05rem;
      border: none;
      cursor: pointer;
      transition: background 0.18s, color 0.18s;
    }
    .custom-modal-btn.cancel {
      background: #ede7f6;
      color: #512da8;
    }
    .custom-modal-btn.cancel:hover {
      background: #d1c4e9;
    }
    .custom-modal-btn.confirm {
      background: linear-gradient(90deg, #512da8 0%, #7c4dff 100%);
      color: #fff;
      box-shadow: 0 2px 8px #b39ddb22;
    }
    .custom-modal-btn.confirm:hover {
      background: linear-gradient(90deg, #7c4dff 0%, #512da8 100%);
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: none; }
    }
  </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Welcome<?= $companyName ? ', ' . htmlspecialchars($companyName) : '' ?>!</h1>
    <div class="dashboard-sections">
        <section class="dashboard-section">
            <h2>Personal Profile</h2>
            <div class="profile-card">
            <?php if ($personalMessage): ?>
                <div class="profile-message"><?= htmlspecialchars($personalMessage) ?></div>
            <?php endif; ?>
            <form class="profile-form" method="post" enctype="multipart/form-data">
                <div style="text-align:center;position:relative;">
                <?php if ($employerPhoto): ?>
                    <img src="<?= htmlspecialchars($employerPhoto) ?>" alt="Profile Photo" class="profile-avatar" id="profileAvatarImg">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($userName) ?>&background=512da8&color=fff&size=128" alt="Profile Photo" class="profile-avatar" id="profileAvatarImg">
                <?php endif; ?>
                <label for="profilePhotoInput" class="profile-avatar-upload" style="top:90px;">Change Photo</label>
                <input type="file" name="photo" id="profilePhotoInput" accept="image/*" style="display:none;">
                </div>
                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($userName) ?>" required>
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($userEmail) ?>" required>
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($employerPhone) ?>">
                <label>Position/Title</label>
                <input type="text" name="position" value="<?= htmlspecialchars($employerPosition) ?>">
                <button type="submit" name="update_personal">Update Personal Profile</button>
            </form>
            <div class="section-divider"></div>
            <h3 style="color:#512da8;">Change Password</h3>
            <form class="profile-form" method="post">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
                <label>New Password</label>
                <input type="password" name="new_password" required>
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>
                <button type="submit" name="update_password">Update Password</button>
            </form>
            </div>
        </section>
        <section class="dashboard-section">
            <h2>Company Profile</h2>
            <?php if ($profileMessage): ?>
                <div class="profile-message"><?= htmlspecialchars($profileMessage) ?></div>
            <?php endif; ?>
            <form class="profile-form" method="post" enctype="multipart/form-data">
                <label>Company Name</label>
                <input type="text" name="company_name" value="<?= htmlspecialchars($companyName) ?>" required>
                <label>Company Description</label>
                <textarea name="company_description" required><?= htmlspecialchars($companyDescription) ?></textarea>
                <label>Company Logo</label><br>
                <?php if ($companyLogo): ?>
                    <img src="<?= htmlspecialchars($companyLogo) ?>" alt="Company Logo" class="company-logo-preview"><br>
                <?php endif; ?>
                <input type="file" name="company_logo" accept="image/*">
                <br><br>
                <button type="submit" name="update_profile">Update Profile</button>
            </form>
        </section>
        <section class="dashboard-section dashboard-info-card">
            <h2>Job Postings</h2>
            <p>Manage your job postings: view, edit, delete, or add new jobs.</p>
            <a href="post-job.php" class="post-job-btn">Post New Job</a>
            <?php if (isset($_GET['delete']) && $_GET['delete'] === 'success'): ?>
                <div class="delete-message">Job deleted successfully!</div>
            <?php endif; ?>
            <?php if (empty($jobs)): ?>
                <div style="padding:1.5rem; color:#888;">You have not posted any jobs yet.</div>
            <?php else: ?>
                <table class="job-table">
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Salary</th>
                        <th>Posted</th>
                        <th>Employer Name</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($jobs as $job): ?>
                        <?php
                        // Count applications for this job
                        $stmt = $pdo->prepare('SELECT COUNT(*) FROM applications WHERE job_id = ?');
                        $stmt->execute([$job['id']]);
                        $appCount = $stmt->fetchColumn();
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= htmlspecialchars($job['location']) ?></td>
                            <td><?= htmlspecialchars($job['salary']) ?></td>
                            <td><?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                            <td><?= htmlspecialchars($job['company_name']) ?></td>
                            <td>
                                <a href="post-job.php?id=<?= $job['id'] ?>" class="job-action-btn edit">Edit</a>
                                <form method="post" style="display:inline;" onsubmit="return showDeleteModal(event, <?= $appCount ?>, this);">
                                    <input type="hidden" name="delete_job_id" value="<?= $job['id'] ?>">
                                    <button type="submit" class="job-action-btn delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </section>
        <section class="dashboard-section dashboard-info-card">
            <h2>Applicants</h2>
            <?php if (empty($jobs)): ?>
                <div style="padding:1.5rem; color:#888;">You have not posted any jobs yet.</div>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                    <div style="margin-bottom: 32px;">
                        <h3 style="color:#512da8; margin-bottom: 12px; text-align:left;">Job: <?= htmlspecialchars($job['title']) ?></h3>
                        <?php if (!empty($jobApplicants[$job['id']])): ?>
                            <div style="display: flex; flex-wrap: wrap; gap: 18px;">
                                <?php foreach ($jobApplicants[$job['id']] as $app): ?>
                                    <div class="applicant-card">
                                        <div class="applicant-card-header">
                                            <span class="applicant-name"><?= htmlspecialchars($app['name']) ?></span>
                                            <span class="applicant-status status-<?= htmlspecialchars($app['status']) ?>">Status: <?= ucfirst($app['status']) ?></span>
                                        </div>
                                        <div class="applicant-card-body">
                                            <div>Email: <a href="mailto:<?= htmlspecialchars($app['email']) ?>"><?= htmlspecialchars($app['email']) ?></a></div>
                                            <div>Applied: <?= date('M d, Y', strtotime($app['applied_at'])) ?></div>
                                        </div>
                                        <div class="applicant-card-footer">
                                            <a href="view-applicant.php?user_id=<?= $app['user_id'] ?>" class="view-profile-btn">View Profile</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div style="color:#888; margin-bottom: 12px;">No applicants yet for this job.</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <section class="dashboard-section dashboard-info-card">
            <h2>Manage Interviews</h2>
            <p>Schedule and manage interviews with candidates. (Coming soon)</p>
        </section>
        <section class="dashboard-section dashboard-info-card">
            <h2>Other Features</h2>
            <p>More employer tools and analytics coming soon.</p>
        </section>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<!-- Custom Delete Confirmation Modal (moved here, outside loops) -->
<div id="deleteModal" class="custom-modal" style="display:none;">
  <div class="custom-modal-content">
    <div class="custom-modal-message" id="deleteModalMessage"></div>
    <div class="custom-modal-actions">
      <button id="deleteModalCancel" class="custom-modal-btn cancel">Cancel</button>
      <button id="deleteModalConfirm" class="custom-modal-btn confirm">Delete</button>
    </div>
  </div>
</div>
<script src="../assets/js/main.js"></script>
<script>
// Custom Delete Modal Logic
let deleteFormToSubmit = null;
function showDeleteModal(e, appCount, form) {
  e.preventDefault();
  deleteFormToSubmit = form;
  const modal = document.getElementById('deleteModal');
  const msg = document.getElementById('deleteModalMessage');
  if (appCount > 0) {
    msg.textContent = `This job has ${appCount} application(s). Deleting it will also delete all applications for this job. Are you sure you want to proceed?`;
  } else {
    msg.textContent = 'Are you sure you want to delete this job?';
  }
  modal.style.display = 'flex';
  return false;
}
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('deleteModal');
  document.getElementById('deleteModalCancel').onclick = function() {
    modal.style.display = 'none';
    deleteFormToSubmit = null;
  };
  document.getElementById('deleteModalConfirm').onclick = function() {
    if (deleteFormToSubmit) {
      modal.style.display = 'none';
      deleteFormToSubmit.submit();
      deleteFormToSubmit = null;
    }
  };
  // Optional: close modal on outside click
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      modal.style.display = 'none';
      deleteFormToSubmit = null;
    }
  });
});
</script>
</body>
</html> 