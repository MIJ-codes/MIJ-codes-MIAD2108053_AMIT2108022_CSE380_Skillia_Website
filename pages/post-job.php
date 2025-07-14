<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';
include '../includes/header.php';

// Only allow logged-in employers
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header('Location: login.php');
    exit;
}

// Get employer_id and company name
$stmt = $pdo->prepare('SELECT id, company_name FROM employers WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$employer = $stmt->fetch();
if (!$employer) {
    die('Employer profile not found.');
}
$employer_id = $employer['id'];
$companyName = $employer['company_name'];

// --- EDIT MODE DETECTION ---
$editMode = false;
$jobId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jobData = [
    'title' => '',
    'location' => '',
    'jobType' => '',
    'salary' => '',
    'description' => '',
    'job_post_type' => 'company',
    'company_name' => $companyName
];
if ($jobId) {
    $stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ? AND employer_id = ?');
    $stmt->execute([$jobId, $employer_id]);
    $job = $stmt->fetch();
    if ($job) {
        $editMode = true;
        $jobData['title'] = $job['title'];
        // Split location and jobType if possible
        if (preg_match('/^(.*) \((.*)\)$/', $job['location'], $matches)) {
            $jobData['location'] = $matches[1];
            $jobData['jobType'] = $matches[2];
        } else {
            $jobData['location'] = $job['location'];
            $jobData['jobType'] = '';
        }
        $jobData['salary'] = $job['salary'];
        $jobData['description'] = $job['description'];
        $jobData['job_post_type'] = $job['job_post_type'] ?? 'company';
        $jobData['company_name'] = $job['company_name'] ?? $companyName;
    } else {
        // Invalid job or not owned by this employer
        header('Location: employer-dashboard.php');
        exit;
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['jobTitle'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $jobType = trim($_POST['jobType'] ?? '');
    $salary = trim($_POST['salary'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $job_post_type = $_POST['job_post_type'] ?? 'company';
    $company_name_input = trim($_POST['company_name'] ?? '');
    $now = date('Y-m-d H:i:s');
    // Company name logic
    $finalCompanyName = ($job_post_type === 'company') ? $company_name_input : 'Personal';
    if ($title && $location && $jobType && $salary && $description && $company_name_input) {
        if ($editMode) {
            // UPDATE
            $stmt = $pdo->prepare('UPDATE jobs SET title=?, description=?, location=?, salary=?, updated_at=?, job_post_type=?, company_name=? WHERE id=? AND employer_id=?');
            $stmt->execute([$title, $description, $location . ' (' . $jobType . ')', $salary, $now, $job_post_type, $company_name_input, $jobId, $employer_id]);
            header('Location: post-job.php?id=' . $jobId . '&success=1');
            exit;
        } else {
            // INSERT
            $stmt = $pdo->prepare('INSERT INTO jobs (employer_id, title, description, location, salary, created_at, updated_at, job_post_type, company_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$employer_id, $title, $description, $location . ' (' . $jobType . ')', $salary, $now, $now, $job_post_type, $company_name_input]);
            header('Location: post-job.php?success=1');
            exit;
        }
    } else {
        $message = 'Please fill in all required fields.';
        // Re-populate form fields on error
        $jobData['title'] = $title;
        $jobData['location'] = $location;
        $jobData['jobType'] = $jobType;
        $jobData['salary'] = $salary;
        $jobData['description'] = $description;
        $jobData['job_post_type'] = $job_post_type;
        $jobData['company_name'] = $company_name_input;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editMode ? 'Edit Job' : 'Post a Job' ?> - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/post-job.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<div class="post-job-main">
    <section class="post-job-hero-section">
        <div class="post-job-hero-bg">
            <!-- Animated geometric shapes -->
            <div class="animated-shape-1"></div>
            <div class="animated-shape-2"></div>
            <div class="animated-shape-3"></div>
            <!-- Floating particles -->
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <!-- Abstract floating icons -->
            <span class="postjob-plus-shape">+</span>
            <span class="postjob-briefcase-shape"><i class="ri-briefcase-4-line"></i></span>
        </div>
        <div class="post-job-hero-content">
            <div class="post-job-hero-visual">
                <div class="post-job-hero-icon">
                    <i class="ri-briefcase-4-line"></i>
                    <span class="post-job-hero-plus">+</span>
                </div>
            </div>
            <h1><span><?= $editMode ? 'Edit' : 'Post' ?></span> a Job</h1>
            <p><?= $editMode ? 'Update your job post and reach more candidates.' : 'Ready to hire? Create a job post and reach thousands of talented candidates instantly.' ?></p>
            <div class="post-job-hero-cta">
                <a href="#post-job-form" class="post-job-cta-btn"><?= $editMode ? 'Edit Job' : 'Start Posting' ?> <i class="ri-arrow-right-line"></i></a>
            </div>
        </div>
    </section>
    <section class="post-job-content-section">
        <h2><?= $editMode ? 'Edit Job' : 'Post a New Job' ?></h2>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success-message">
                <?= $editMode ? 'Job updated successfully!' : 'Job posted successfully!' ?>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $message): ?>
            <div class="success-message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form class="post-job-form" method="post" id="post-job-form">
            <div class="form-group">
                <label for="jobTitle">Job Title</label>
                <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g. Frontend Developer" required value="<?= htmlspecialchars($jobData['title']) ?>">
            </div>
            <div class="form-group">
                <label>Job Post Type</label>
                <div style="display:flex;gap:24px;align-items:center;">
                    <label style="font-weight:500;cursor:pointer;">
                        <input type="radio" name="job_post_type" value="company" <?= $jobData['job_post_type']==='company'?'checked':'' ?>>
                        <span style="margin-left:6px;">Company</span>
                    </label>
                    <label style="font-weight:500;cursor:pointer;">
                        <input type="radio" name="job_post_type" value="personal" <?= $jobData['job_post_type']==='personal'?'checked':'' ?>>
                        <span style="margin-left:6px;">Personal</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" id="company_name" name="company_name" required value="<?= htmlspecialchars($jobData['company_name']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="e.g. Dhaka, Bangladesh" required value="<?= htmlspecialchars($jobData['location']) ?>">
            </div>
            <div class="form-group">
                <label for="jobType">Job Type</label>
                <select id="jobType" name="jobType" required>
                    <option value="">Select type</option>
                    <option value="Full-time" <?= $jobData['jobType'] === 'Full-time' ? 'selected' : '' ?>>Full Time</option>
                    <option value="Part-time" <?= $jobData['jobType'] === 'Part-time' ? 'selected' : '' ?>>Part Time</option>
                    <option value="Contract" <?= $jobData['jobType'] === 'Contract' ? 'selected' : '' ?>>Contract</option>
                    <option value="Internship" <?= $jobData['jobType'] === 'Internship' ? 'selected' : '' ?>>Internship</option>
                </select>
            </div>
            <div class="form-group">
                <label for="salary">Salary Range</label>
                <input type="text" id="salary" name="salary" placeholder="e.g. 30,000 - 50,000 BDT" required value="<?= htmlspecialchars($jobData['salary']) ?>">
            </div>
            <div class="form-group">
                <label for="description">Job Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Describe the job role, requirements, and responsibilities..." required><?= htmlspecialchars($jobData['description']) ?></textarea>
            </div>
            <button type="submit" class="post-job-btn">
                <span><?= $editMode ? 'Update Job' : 'Post Job' ?></span>
                <i class="ri-send-plane-line"></i>
            </button>
        </form>
    </section>
</div>
<?php include '../includes/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const companyRadio = document.querySelector('input[name="job_post_type"][value="company"]');
    const personalRadio = document.querySelector('input[name="job_post_type"][value="personal"]');
    const companyNameInput = document.getElementById('company_name');
    const employerCompanyName = <?= json_encode($companyName) ?>;
    function setCompanyNameReadonly(val) {
        companyNameInput.value = val;
        companyNameInput.readOnly = true;
    }
    companyRadio.addEventListener('change', function() {
        if (this.checked) setCompanyNameReadonly(employerCompanyName);
    });
    personalRadio.addEventListener('change', function() {
        if (this.checked) setCompanyNameReadonly('Personal');
    });
    // On page load, enforce readonly and correct value
    if (companyRadio.checked) setCompanyNameReadonly(employerCompanyName);
    if (personalRadio.checked) setCompanyNameReadonly('Personal');
});
</script>
</body>
</html> 