<?php
session_start();
require_once '../includes/db.php';

// Only allow logged-in employers
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header('Location: login.php');
    exit;
}

// Get employer_id
$stmt = $pdo->prepare('SELECT id FROM employers WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$employer = $stmt->fetch();
if (!$employer) {
    die('Employer profile not found.');
}
$employer_id = $employer['id'];

// Get job ID
$job_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$job_id) {
    die('Invalid job ID.');
}

// Fetch job
$stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ? AND employer_id = ?');
$stmt->execute([$job_id, $employer_id]);
$job = $stmt->fetch();
if (!$job) {
    die('Job not found or you do not have permission to edit this job.');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['jobTitle'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $jobType = trim($_POST['jobType'] ?? '');
    $salary = trim($_POST['salary'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $now = date('Y-m-d H:i:s');
    if ($title && $location && $jobType && $salary && $description) {
        $stmt = $pdo->prepare('UPDATE jobs SET title = ?, description = ?, location = ?, salary = ?, updated_at = ? WHERE id = ? AND employer_id = ?');
        $stmt->execute([$title, $description, $location . ' (' . $jobType . ')', $salary, $now, $job_id, $employer_id]);
        $message = 'Job updated successfully!';
        // Refresh job data
        $stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ? AND employer_id = ?');
        $stmt->execute([$job_id, $employer_id]);
        $job = $stmt->fetch();
        // Optionally redirect to dashboard after update
        header('Location: employer-dashboard.php');
        exit;
    } else {
        $message = 'Please fill in all required fields.';
    }
}

// Parse location and job type from stored location field
$locationValue = $job['location'];
$jobTypeValue = '';
if (preg_match('/^(.*) \(([^)]+)\)$/', $locationValue, $matches)) {
    $locationValue = $matches[1];
    $jobTypeValue = $matches[2];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/post-job.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
    <style>
        .edit-job-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px #b39ddb33; padding: 32px; }
        .edit-job-title { color: #512da8; margin-bottom: 18px; }
    </style>
</head>
<body>
<div class="edit-job-container">
    <h2 class="edit-job-title">Edit Job</h2>
    <?php if ($message): ?>
        <div style="background:#e8f5e8;color:#2e7d32;padding:12px;border-radius:6px;margin-bottom:18px;max-width:600px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="jobTitle">Job Title</label>
            <input type="text" id="jobTitle" name="jobTitle" value="<?= htmlspecialchars($job['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($locationValue) ?>" required>
        </div>
        <div class="form-group">
            <label for="jobType">Job Type</label>
            <select id="jobType" name="jobType" required>
                <option value="">Select type</option>
                <option value="Full-time" <?= $jobTypeValue === 'Full-time' ? 'selected' : '' ?>>Full Time</option>
                <option value="Part-time" <?= $jobTypeValue === 'Part-time' ? 'selected' : '' ?>>Part Time</option>
                <option value="Contract" <?= $jobTypeValue === 'Contract' ? 'selected' : '' ?>>Contract</option>
                <option value="Internship" <?= $jobTypeValue === 'Internship' ? 'selected' : '' ?>>Internship</option>
            </select>
        </div>
        <div class="form-group">
            <label for="salary">Salary Range</label>
            <input type="text" id="salary" name="salary" value="<?= htmlspecialchars($job['salary']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($job['description']) ?></textarea>
        </div>
        <button type="submit" class="post-job-btn">
            <span>Update Job</span>
            <i class="ri-save-line"></i>
        </button>
        <a href="employer-dashboard.php" style="margin-left:18px;color:#512da8;text-decoration:underline;">Cancel</a>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 