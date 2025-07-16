<?php
require_once '../includes/db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include '../includes/header.php';

// Handle job application
$applyMessage = '';
if (isset($_POST['apply_job_id']) && isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'jobseeker') {
    $job_id = (int)$_POST['apply_job_id'];
    $user_id = $_SESSION['user_id'];
    // Get seeker_id from job_seekers table
    $stmt = $pdo->prepare('SELECT id FROM job_seekers WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $seeker = $stmt->fetch();
    if ($seeker) {
        $seeker_id = $seeker['id'];
        // Check if already applied
        $stmt = $pdo->prepare('SELECT id FROM applications WHERE job_id = ? AND seeker_id = ?');
        $stmt->execute([$job_id, $seeker_id]);
        if ($stmt->fetch()) {
            $applyMessage = 'You have already applied to this job.';
        } else {
            // Insert application
            $stmt = $pdo->prepare('INSERT INTO applications (job_id, seeker_id, status, applied_at) VALUES (?, ?, "pending", NOW())');
            $stmt->execute([$job_id, $seeker_id]);
            $applyMessage = 'Application submitted successfully!';
        }
    } else {
        $applyMessage = 'Profile not found.';
    }
}

// Fetch all categories for filter
$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name ASC')->fetchAll();
$selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$selectedLocation = isset($_GET['location']) ? $_GET['location'] : '';
$selectedExperience = isset($_GET['experience_level']) ? $_GET['experience_level'] : '';
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch jobs with optional filters
$where = [];
$params = [];
if ($selectedCategory) {
    $where[] = 'jobs.category_id = ?';
    $params[] = $selectedCategory;
}
if ($selectedLocation) {
    $where[] = 'jobs.location LIKE ?';
    $params[] = $selectedLocation . '%';
}
if ($selectedExperience) {
    $where[] = 'jobs.experience_level = ?';
    $params[] = $selectedExperience;
}
if ($searchTerm !== '') {
    $where[] = '(jobs.title LIKE ? OR jobs.description LIKE ?)';
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}
$sql = 'SELECT jobs.*, employers.company_name, employers.company_logo, employers.photo, categories.name AS category_name FROM jobs JOIN employers ON jobs.employer_id = employers.id LEFT JOIN categories ON jobs.category_id = categories.id';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY jobs.created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$jobs = $stmt->fetchAll();

// Fetch applied jobs for the current seeker (for button state)
$appliedJobs = [];
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'jobseeker') {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT id FROM job_seekers WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $seeker = $stmt->fetch();
    if ($seeker) {
        $seeker_id = $seeker['id'];
        $stmt = $pdo->prepare('SELECT job_id FROM applications WHERE seeker_id = ?');
        $stmt->execute([$seeker_id]);
        $appliedJobs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Job Board</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/job-board.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<div class="job-board-main">
    <section class="job-board-hero-section">
        <div class="job-board-hero-content">
            <h1 class="job-board-hero-title">Job Board</h1>
            <p class="job-board-hero-subtitle">Explore all available jobs and find your next opportunity</p>
            <div class="job-board-hero-controls">
                <div class="job-board-search-row">
                    <form class="search-container" method="get" action="">
                        <input type="text" name="search" class="job-board-search-input" placeholder="Search for jobs..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="search-icon" aria-label="Search"><i class="ri-search-line"></i></button>
                    </form>
                </div>
                <form method="get" id="categoryFilterForm">
                    <label for="category" style="font-weight:500;margin-right:8px;">Filter by:</label>
                    <div class="custom-category-dropdown" tabindex="0">
                        <span class="selected-category">
                            <?php
                            $catName = 'All Categories';
                            foreach ($categories as $cat) {
                                if ($selectedCategory == $cat['id']) $catName = htmlspecialchars($cat['name']);
                            }
                            echo $catName;
                            ?>
                        </span>
                        <ul class="category-options" style="display:none;">
                            <li data-value="">All Categories</li>
                            <?php foreach ($categories as $cat): ?>
                                <li data-value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'class="selected"' : '' ?>><?= htmlspecialchars($cat['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="category" id="categoryHiddenInput" value="<?= $selectedCategory ? $selectedCategory : '' ?>">
                    </div>
                    <!-- Location Dropdown -->
                    <div class="custom-category-dropdown location-dropdown" tabindex="0">
                        <span class="selected-category">
                            <?= $selectedLocation ? htmlspecialchars($selectedLocation) : 'All Locations' ?>
                        </span>
                        <ul class="category-options" style="display:none;">
                            <li data-value="">All Locations</li>
                            <li data-value="Remote" <?= $selectedLocation === 'Remote' ? 'class="selected"' : '' ?>>Remote</li>
                            <li data-value="New York" <?= $selectedLocation === 'New York' ? 'class="selected"' : '' ?>>New York</li>
                            <li data-value="San Francisco" <?= $selectedLocation === 'San Francisco' ? 'class="selected"' : '' ?>>San Francisco</li>
                            <li data-value="London" <?= $selectedLocation === 'London' ? 'class="selected"' : '' ?>>London</li>
                            <li data-value="Berlin" <?= $selectedLocation === 'Berlin' ? 'class="selected"' : '' ?>>Berlin</li>
                            <li data-value="Dhaka, Bangladesh" <?= $selectedLocation === 'Dhaka, Bangladesh' ? 'class="selected"' : '' ?>>Dhaka, Bangladesh</li>
                        </ul>
                        <input type="hidden" name="location" id="locationHiddenInput" value="<?= htmlspecialchars($selectedLocation) ?>">
                    </div>
                    <!-- Experience Level Dropdown -->
                    <div class="custom-category-dropdown experience-dropdown" tabindex="0">
                        <span class="selected-category">
                            <?= $selectedExperience ? htmlspecialchars($selectedExperience) : 'All Experience Levels' ?>
                        </span>
                        <ul class="category-options" style="display:none;">
                            <li data-value="">All Experience Levels</li>
                            <li data-value="Entry Level" <?= $selectedExperience === 'Entry Level' ? 'class="selected"' : '' ?>>Entry Level</li>
                            <li data-value="Mid Level" <?= $selectedExperience === 'Mid Level' ? 'class="selected"' : '' ?>>Mid Level</li>
                            <li data-value="Senior Level" <?= $selectedExperience === 'Senior Level' ? 'class="selected"' : '' ?>>Senior Level</li>
                            <li data-value="Manager" <?= $selectedExperience === 'Manager' ? 'class="selected"' : '' ?>>Manager</li>
                        </ul>
                        <input type="hidden" name="experience_level" id="experienceHiddenInput" value="<?= htmlspecialchars($selectedExperience) ?>">
                    </div>
                </form>
            </div>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'employer'): ?>
                <div class="job-board-post-section">
                    <div class="job-board-post-title">Want to hire?</div>
                    <a href="post-job.php" class="job-board-post-btn">Post a Job</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php if ($applyMessage): ?>
        <div style="background:#e8f5e8;color:#2e7d32;padding:12px;border-radius:6px;margin:20px auto;max-width:600px;text-align:center;">
            <?= htmlspecialchars($applyMessage) ?>
        </div>
    <?php endif; ?>
    <section class="job-board-list-section">
        <div class="job-board-list">
            <?php if (count($jobs) === 0): ?>
                <div style="padding:2rem; text-align:center; color:var(--text-light); font-size:1.2rem;">No jobs available yet. Please check back soon!</div>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                    <div class="job-card">
                <div class="job-card-header">
                            <div class="job-company-logo">
                                <?php
                                $avatar = '../assets/images/default-avatar.png';
                                if (($job['job_post_type'] ?? 'company') === 'company' && !empty($job['company_logo'])) {
                                    $avatar = $job['company_logo'];
                                } elseif (($job['job_post_type'] ?? 'company') === 'personal' && !empty($job['photo'])) {
                                    $avatar = $job['photo'];
                                }
                                ?>
                                <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($job['company_name'] ?? 'Personal') ?>" style="width:48px;height:48px;border-radius:50%;object-fit:cover;box-shadow:0 2px 8px #b39ddb22;">
                </div>
                            <div class="job-company-name">
                                <?= ($job['job_post_type'] ?? 'company') === 'company' ? htmlspecialchars($job['company_name']) : 'Personal' ?>
            </div>
                </div>
                <div class="job-card-content">
                            <h3 class="job-title"><?= htmlspecialchars($job['title']) ?></h3>
                            <?php if (!empty($job['category_name'])): ?>
                                <span class="job-category-badge" style="display:inline-block;background:#e1e5f2;color:#667eea;font-size:0.95rem;font-weight:600;border-radius:12px;padding:2px 12px;margin-bottom:8px;vertical-align:middle;">
                                    <?= htmlspecialchars($job['category_name']) ?>
                                </span>
                            <?php endif; ?>
                    <div class="job-meta">
                                <span><i class="ri-map-pin-line"></i> <?= htmlspecialchars($job['location']) ?></span>
                                <span><i class="ri-money-dollar-circle-line"></i> <?= htmlspecialchars($job['salary']) ?></span>
                    </div>
                            <div class="job-desc"><?= nl2br(htmlspecialchars($job['description'])) ?></div>
                </div>
                <div class="job-card-footer">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'jobseeker'): ?>
                                <?php if (in_array($job['id'], $appliedJobs)): ?>
                                    <button class="job-apply-btn" style="background:#e0e0e0;color:#888;cursor:not-allowed;">Already Applied</button>
                                <?php else: ?>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="apply_job_id" value="<?= $job['id'] ?>">
                                        <button type="submit" class="job-apply-btn">Apply Now</button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="job-apply-btn">Login to Apply</a>
                            <?php endif; ?>
                </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/job-board.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 