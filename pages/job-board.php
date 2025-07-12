<?php
require_once '../includes/db.php';
session_start();
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

// Fetch jobs with employer and company name, logo, and photo
$stmt = $pdo->prepare('
    SELECT jobs.*, employers.company_name, employers.company_logo, employers.photo
    FROM jobs
    JOIN employers ON jobs.employer_id = employers.id
    ORDER BY jobs.created_at DESC
');
$stmt->execute();
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