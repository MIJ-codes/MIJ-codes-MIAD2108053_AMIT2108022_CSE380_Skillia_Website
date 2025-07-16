<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    'company_name' => $companyName,
    'category_id' => '',
    'experience_level' => ''
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
        $jobData['category_id'] = $job['category_id'] ?? '';
        $jobData['experience_level'] = $job['experience_level'] ?? '';
    } else {
        // Invalid job or not owned by this employer
        header('Location: employer-dashboard.php');
        exit;
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['jobTitle'] ?? '');
    $jobType = trim($_POST['jobType'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $experience_level = trim($_POST['experience_level'] ?? '');
    $salary = trim($_POST['salary'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $job_post_type = $_POST['job_post_type'] ?? 'company';
    $company_name_input = trim($_POST['company_name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $now = date('Y-m-d H:i:s');
    // Company name logic
    $finalCompanyName = ($job_post_type === 'company') ? $company_name_input : 'Personal';
    if ($title && $location && $jobType && $salary && $description && $company_name_input && $category_id && $experience_level) {
        if ($editMode) {
            // UPDATE
            $stmt = $pdo->prepare('UPDATE jobs SET title=?, description=?, location=?, experience_level=?, salary=?, updated_at=?, job_post_type=?, company_name=?, category_id=? WHERE id=? AND employer_id=?');
            $stmt->execute([$title, $description, $location . ' (' . $jobType . ')', $experience_level, $salary, $now, $job_post_type, $company_name_input, $category_id, $jobId, $employer_id]);
            if ($stmt->errorCode() !== '00000') {
                print_r($stmt->errorInfo());
                exit;
            }
            header('Location: post-job.php?id=' . $jobId . '&success=1');
            exit;
        } else {
            // INSERT
            $stmt = $pdo->prepare('INSERT INTO jobs (employer_id, title, description, location, experience_level, salary, created_at, updated_at, job_post_type, company_name, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$employer_id, $title, $description, $location . ' (' . $jobType . ')', $experience_level, $salary, $now, $now, $job_post_type, $company_name_input, $category_id]);
            if ($stmt->errorCode() !== '00000') {
                print_r($stmt->errorInfo());
                exit;
            }
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
        $jobData['category_id'] = $category_id;
        $jobData['experience_level'] = $experience_level;
    }
}
// Fetch all categories for dropdown
$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name ASC')->fetchAll();
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
                <div class="custom-category-dropdown location-dropdown" tabindex="0">
                    <span class="selected-category">
                        <?= $jobData['location'] ? htmlspecialchars($jobData['location']) : 'Select Location' ?>
                    </span>
                    <ul class="category-options" style="display:none;">
                        <li data-value="">Select Location</li>
                        <li data-value="Remote" <?= $jobData['location'] === 'Remote' ? 'class="selected"' : '' ?>>Remote</li>
                        <li data-value="New York" <?= $jobData['location'] === 'New York' ? 'class="selected"' : '' ?>>New York</li>
                        <li data-value="San Francisco" <?= $jobData['location'] === 'San Francisco' ? 'class="selected"' : '' ?>>San Francisco</li>
                        <li data-value="London" <?= $jobData['location'] === 'London' ? 'class="selected"' : '' ?>>London</li>
                        <li data-value="Berlin" <?= $jobData['location'] === 'Berlin' ? 'class="selected"' : '' ?>>Berlin</li>
                        <li data-value="Dhaka, Bangladesh" <?= $jobData['location'] === 'Dhaka, Bangladesh' ? 'class="selected"' : '' ?>>Dhaka, Bangladesh</li>
                    </ul>
                    <input type="hidden" name="location" value="<?= htmlspecialchars($jobData['location']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="experience_level">Experience Level</label>
                <div class="custom-category-dropdown experience-dropdown" tabindex="0">
                    <span class="selected-category">
                        <?= $jobData['experience_level'] ? htmlspecialchars($jobData['experience_level']) : 'Select Experience Level' ?>
                    </span>
                    <ul class="category-options" style="display:none;">
                        <li data-value="">Select Experience Level</li>
                        <li data-value="Entry Level" <?= (isset($jobData['experience_level']) && $jobData['experience_level'] === 'Entry Level') ? 'class="selected"' : '' ?>>Entry Level</li>
                        <li data-value="Mid Level" <?= (isset($jobData['experience_level']) && $jobData['experience_level'] === 'Mid Level') ? 'class="selected"' : '' ?>>Mid Level</li>
                        <li data-value="Senior Level" <?= (isset($jobData['experience_level']) && $jobData['experience_level'] === 'Senior Level') ? 'class="selected"' : '' ?>>Senior Level</li>
                        <li data-value="Manager" <?= (isset($jobData['experience_level']) && $jobData['experience_level'] === 'Manager') ? 'class="selected"' : '' ?>>Manager</li>
                    </ul>
                    <input type="hidden" name="experience_level" value="<?= htmlspecialchars($jobData['experience_level']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="jobType">Job Type</label>
                <div class="custom-category-dropdown type-dropdown" tabindex="0">
                    <span class="selected-category">
                        <?= $jobData['jobType'] ? htmlspecialchars($jobData['jobType']) : 'Select type' ?>
                    </span>
                    <ul class="category-options" style="display:none;">
                        <li data-value="">Select type</li>
                        <li data-value="Full-time" <?= $jobData['jobType'] === 'Full-time' ? 'class="selected"' : '' ?>>Full Time</li>
                        <li data-value="Part-time" <?= $jobData['jobType'] === 'Part-time' ? 'class="selected"' : '' ?>>Part Time</li>
                        <li data-value="Contract" <?= $jobData['jobType'] === 'Contract' ? 'class="selected"' : '' ?>>Contract</li>
                        <li data-value="Internship" <?= $jobData['jobType'] === 'Internship' ? 'class="selected"' : '' ?>>Internship</li>
                    </ul>
                    <input type="hidden" name="jobType" value="<?= htmlspecialchars($jobData['jobType']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="salary">Salary Range</label>
                <input type="text" id="salary" name="salary" placeholder="e.g. 30,000 - 50,000 BDT" required value="<?= htmlspecialchars($jobData['salary']) ?>">
            </div>
            <div class="form-group">
                <label for="description">Job Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Describe the job role, requirements, and responsibilities..." required><?= htmlspecialchars($jobData['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Job Category</label>
                <div class="custom-category-dropdown category-dropdown" tabindex="0">
                    <span class="selected-category">
                        <?php
                        $catLabel = $jobData['category_id'] ? htmlspecialchars($categories[array_search($jobData['category_id'], array_column($categories, 'id'))]['name']) : 'Select category';
                        echo $catLabel;
                        ?>
                    </span>
                    <ul class="category-options" style="display:none;">
                        <li data-value="">Select category</li>
                        <?php foreach ($categories as $cat): ?>
                            <li data-value="<?= $cat['id'] ?>" <?= $jobData['category_id'] == $cat['id'] ? 'class="selected"' : '' ?>><?= htmlspecialchars($cat['name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($jobData['category_id']) ?>">
                </div>
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
// Portal dropdown menu logic for post-job page
(function() {
    let openDropdown = null;
    let originalParent = null;
    let originalNextSibling = null;
    let portalMenu = null;

    function closeDropdown() {
        if (openDropdown && portalMenu) {
            // Move menu back to original parent
            if (originalParent && portalMenu) {
                originalParent.insertBefore(portalMenu, originalNextSibling);
                portalMenu.style.position = '';
                portalMenu.style.left = '';
                portalMenu.style.top = '';
                portalMenu.style.width = '';
                portalMenu.style.zIndex = '';
                portalMenu.style.display = 'none';
            }
            openDropdown.classList.remove('open');
            openDropdown = null;
            portalMenu = null;
            originalParent = null;
            originalNextSibling = null;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.custom-category-dropdown').forEach(function(dropdown) {
            const selected = dropdown.querySelector('.selected-category');
            const menu = dropdown.querySelector('.category-options');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            // Set initial selected label
            const initial = menu.querySelector('li.selected');
            if (initial) selected.textContent = initial.textContent;
            // Open/close dropdown
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                if (openDropdown === dropdown) {
                    closeDropdown();
                    return;
                }
                closeDropdown();
                openDropdown = dropdown;
                portalMenu = menu;
                originalParent = menu.parentNode;
                originalNextSibling = menu.nextSibling;
                // Move menu to body
                document.body.appendChild(menu);
                // Position menu below dropdown
                const rect = dropdown.getBoundingClientRect();
                menu.style.position = 'absolute';
                menu.style.left = rect.left + 'px';
                menu.style.top = (rect.bottom + window.scrollY) + 'px';
                menu.style.width = rect.width + 'px';
                menu.style.zIndex = 9999;
                menu.style.display = 'block';
                dropdown.classList.add('open');
            });
            // Option select
            menu.querySelectorAll('li').forEach(function(option) {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    selected.textContent = option.textContent;
                    hiddenInput.value = option.getAttribute('data-value');
                    menu.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
                    option.classList.add('selected');
                    closeDropdown();
                });
            });
        });
        // Close on outside click
        document.addEventListener('click', function() {
            closeDropdown();
        });
        // Close on resize only (not on scroll)
        window.addEventListener('resize', closeDropdown);
    });
})();
</script>
</body>
</html> 