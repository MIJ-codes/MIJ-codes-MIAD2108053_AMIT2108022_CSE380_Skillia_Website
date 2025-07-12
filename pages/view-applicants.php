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

// Check that the job belongs to this employer
$stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = ? AND employer_id = ?');
$stmt->execute([$job_id, $employer_id]);
$job = $stmt->fetch();
if (!$job) {
    die('Job not found or you do not have permission to view applicants for this job.');
}

// Handle status update
$statusMessage = '';
if (isset($_POST['application_id'], $_POST['new_status'])) {
    $application_id = (int)$_POST['application_id'];
    $new_status = $_POST['new_status'];
    if (in_array($new_status, ['pending', 'accepted', 'rejected'])) {
        $stmt = $pdo->prepare('UPDATE applications SET status = ? WHERE id = ?');
        $stmt->execute([$new_status, $application_id]);
        $statusMessage = 'Application status updated.';
    }
}

// Fetch applicants for this job (with job seeker profile info)
$stmt = $pdo->prepare('
    SELECT applications.*, users.name, users.email, job_seekers.skills, job_seekers.bio, job_seekers.resume
    FROM applications
    JOIN job_seekers ON applications.seeker_id = job_seekers.id
    JOIN users ON job_seekers.user_id = users.id
    WHERE applications.job_id = ?
    ORDER BY applications.applied_at DESC
');
$stmt->execute([$job_id]);
$applicants = $stmt->fetchAll();

// Handle resume view (simple inline, not modal for now)
$viewResumeId = isset($_GET['resume']) ? (int)$_GET['resume'] : 0;
$resumeApplicant = null;
if ($viewResumeId) {
    foreach ($applicants as $app) {
        if ($app['id'] == $viewResumeId) {
            $resumeApplicant = $app;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicants for <?= htmlspecialchars($job['title']) ?> - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
    <style>
        .applicants-container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px #b39ddb33; padding: 32px; }
        .applicants-title { color: #512da8; margin-bottom: 18px; }
        .applicants-table { width: 100%; border-collapse: collapse; margin-top: 18px; background: #faf8ff; border-radius: 10px; overflow: hidden; }
        .applicants-table th, .applicants-table td { padding: 12px 10px; text-align: left; }
        .applicants-table th { background: #ede7f6; color: #512da8; font-weight: 600; }
        .applicants-table tr:not(:last-child) { border-bottom: 1px solid #e0d7f7; }
        .status-pending { color: #b39ddb; font-weight: 600; }
        .status-accepted { color: #2e7d32; font-weight: 600; }
        .status-rejected { color: #d32f2f; font-weight: 600; }
        .status-btn { background: #ede7f6; color: #512da8; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 600; cursor: pointer; margin-right: 6px; }
        .status-btn.accept { background: #2e7d32; color: #fff; }
        .status-btn.reject { background: #d32f2f; color: #fff; }
        .status-btn.pending { background: #b39ddb; color: #fff; }
        .back-link { display:inline-block; margin-bottom:18px; color:#512da8; text-decoration:underline; }
        .status-message { background:#e8f5e8;color:#2e7d32;padding:12px;border-radius:6px;margin-bottom:18px;max-width:600px;text-align:center; }
    </style>
</head>
<body>
<div class="applicants-container">
    <a href="employer-dashboard.php" class="back-link">&larr; Back to Dashboard</a>
    <h2 class="applicants-title">Applicants for "<?= htmlspecialchars($job['title']) ?>"</h2>
    <?php if ($statusMessage): ?>
        <div class="status-message"><?= htmlspecialchars($statusMessage) ?></div>
    <?php endif; ?>
    <?php if (empty($applicants)): ?>
        <div style="padding:1.5rem; color:#888;">No applicants for this job yet.</div>
    <?php else: ?>
        <table class="applicants-table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Applied At</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($applicants as $app): ?>
                <tr>
                    <td><?= htmlspecialchars($app['name']) ?></td>
                    <td><?= htmlspecialchars($app['email']) ?></td>
                    <td class="status-<?= htmlspecialchars($app['status']) ?>"><?= ucfirst($app['status']) ?></td>
                    <td><?= date('M d, Y', strtotime($app['applied_at'])) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <button type="submit" name="new_status" value="accepted" class="status-btn accept" <?= $app['status'] === 'accepted' ? 'disabled' : '' ?>>Accept</button>
                            <button type="submit" name="new_status" value="rejected" class="status-btn reject" <?= $app['status'] === 'rejected' ? 'disabled' : '' ?>>Reject</button>
                            <button type="submit" name="new_status" value="pending" class="status-btn pending" <?= $app['status'] === 'pending' ? 'disabled' : '' ?>>Pending</button>
                        </form>
                        <a href="view-applicants.php?id=<?= $job_id ?>&resume=<?= $app['id'] ?>" class="status-btn" style="background:#512da8;color:#fff;">View Resume</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<?php if ($resumeApplicant): ?>
<div style="margin-top:32px;padding:24px;background:#f6f6fb;border-radius:12px;box-shadow:0 2px 8px #b39ddb22;max-width:600px;">
    <h3 style="color:#512da8;">Resume for <?= htmlspecialchars($resumeApplicant['name']) ?></h3>
    <p><strong>Email:</strong> <?= htmlspecialchars($resumeApplicant['email']) ?></p>
    <p><strong>Skills:</strong> <?= htmlspecialchars($resumeApplicant['skills']) ?: 'N/A' ?></p>
    <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($resumeApplicant['bio'])) ?: 'N/A' ?></p>
    <?php if ($resumeApplicant['resume']): ?>
        <p><strong>Resume File:</strong> <a href="<?= htmlspecialchars($resumeApplicant['resume']) ?>" target="_blank">Download/View</a></p>
    <?php endif; ?>
    <a href="view-applicants.php?id=<?= $job_id ?>" class="status-btn" style="background:#888;color:#fff;margin-top:12px;">Close</a>
</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>
</body>
</html> 