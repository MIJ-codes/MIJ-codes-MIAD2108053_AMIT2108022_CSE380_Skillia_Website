<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';

// Only allow logged-in employers
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header('Location: login.php');
    exit;
}

// Get job seeker user_id and job_id from URL
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : 0;
if (!$user_id) {
    die('Invalid applicant.');
}

// Handle application status update
if (isset($_POST['update_status'], $_POST['new_status'])) {
    $new_status = $_POST['new_status'];
    if (in_array($new_status, ['pending', 'accepted', 'rejected'])) {
        $stmt = $pdo->prepare('UPDATE applications SET status = ? WHERE seeker_id = ? AND job_id = ?');
        $stmt->execute([$new_status, $user_id, $job_id]);
        $status_updated = true;
        // Send notification to job seeker if accepted/rejected
        if (in_array($new_status, ['accepted', 'rejected'])) {
            // Fetch job title and company name
            $stmt = $pdo->prepare('SELECT j.title, e.company_name FROM jobs j JOIN employers e ON j.employer_id = e.id WHERE j.id = ?');
            $stmt->execute([$job_id]);
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            $jobTitle = $info['title'] ?? 'Job';
            $companyName = $info['company_name'] ?? '';
            $notif_title = 'Application Update';
            if ($new_status === 'accepted') {
                $notif_msg = "Your application for '$jobTitle' at $companyName was marked as accepted.";
            } else if ($new_status === 'rejected') {
                $notif_msg = "Your application for '$jobTitle' at $companyName was marked as rejected.";
            }
            $notif_type = 'application_status';
            $stmt = $pdo->prepare('INSERT INTO notifications (user_id, user_type, title, message, type, related_id, related_type) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$user_id, 'job_seeker', $notif_title, $notif_msg, $notif_type, $job_id, 'application']);
        }
    }
}

// Fetch user info
$stmt = $pdo->prepare('SELECT name, email FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) {
    die('User not found.');
}
$name = $user['name'];
$email = $user['email'];

// Fetch job seeker profile
$stmt = $pdo->prepare('SELECT * FROM job_seekers WHERE user_id = ?');
$stmt->execute([$user_id]);
$profile = $stmt->fetch();

// If no profile exists, create a basic one
if (!$profile) {
    $profile = [
        'phone' => '',
        'location' => '',
        'linkedin' => '',
        'portfolio' => '',
        'skills' => '',
        'experience' => '',
        'education' => '',
        'bio' => '',
        'photo' => ''
    ];
}

// Get current application status if job_id is provided
$current_status = 'pending';
if ($job_id) {
    $stmt = $pdo->prepare('SELECT status FROM applications WHERE seeker_id = ? AND job_id = ?');
    $stmt->execute([$user_id, $job_id]);
    $application = $stmt->fetch();
    if ($application) {
        $current_status = $application['status'];
    }
}

// Generate avatar if no photo
$avatar_url = '';
if (!empty($profile['photo'])) {
    $avatar_url = '../uploads/' . $profile['photo'];
} else {
    $avatar_url = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&size=200&background=7c4dff&color=fff&bold=true';
}

include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/applicant-profile.css">

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Applicant Profile</h1>
        <a href="employer-dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>

    <?php if (isset($status_updated)): ?>
    <div class="alert alert-success">
        Application status updated successfully!
    </div>
    <?php endif; ?>

    <div class="profile-section">
        <div class="profile-header-card">
            <img src="<?= htmlspecialchars($avatar_url) ?>" alt="<?= htmlspecialchars($name) ?>" class="profile-avatar">
            <div class="profile-header-info">
                <h1><?= htmlspecialchars($name) ?></h1>
                <?php if (!empty($profile['title'])): ?>
                    <div class="profile-title"> <?= htmlspecialchars($profile['title']) ?> </div>
                <?php endif; ?>
                <div class="profile-email"> <?= htmlspecialchars($email) ?> </div>
                <div class="profile-contact-row">
                    <?php if ($profile['phone']): ?>
                        <div class="profile-contact"><i class="ri-phone-fill"></i><?= htmlspecialchars($profile['phone']) ?></div>
                    <?php endif; ?>
                    <?php if ($profile['location']): ?>
                        <div class="profile-location"><i class="ri-map-pin-2-fill"></i><?= htmlspecialchars($profile['location']) ?></div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($profile['expected_salary'])): ?>
                    <div class="profile-field"><strong>Expected Salary:</strong> <?= htmlspecialchars($profile['expected_salary']) ?></div>
                <?php endif; ?>
                <?php if (!empty($profile['languages'])): ?>
                    <div class="profile-field"><strong>Languages:</strong> <?= htmlspecialchars($profile['languages']) ?></div>
                <?php endif; ?>
                <?php if (!empty($profile['github'])): ?>
                    <div class="profile-link"><a href="<?= htmlspecialchars($profile['github']) ?>" target="_blank">GitHub Profile</a></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Remove the application status section (status badge and Accept/Reject buttons) from here -->

        <div class="profile-details">
            <div class="detail-row">
                <div class="detail-group">
                    <h3>Skills</h3>
                    <p><?= !empty($profile['skills']) ? htmlspecialchars($profile['skills']) : 'Not specified' ?></p>
                </div>
                <div class="detail-group">
                    <h3>Experience</h3>
                    <p><?= !empty($profile['experience']) ? htmlspecialchars($profile['experience']) : 'Not specified' ?></p>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-group">
                    <h3>Education</h3>
                    <p><?= !empty($profile['education']) ? htmlspecialchars($profile['education']) : 'Not specified' ?></p>
                </div>
                <div class="detail-group">
                    <h3>Bio</h3>
                    <p><?= !empty($profile['bio']) ? htmlspecialchars($profile['bio']) : 'Not specified' ?></p>
                </div>
            </div>

            <?php if ($profile['linkedin'] || $profile['portfolio']): ?>
            <div class="detail-row">
                <div class="detail-group">
                    <h3>Links</h3>
                    <div class="links">
                        <?php if ($profile['linkedin']): ?>
                            <a href="<?= htmlspecialchars($profile['linkedin']) ?>" target="_blank" class="link-btn linkedin">
                                🔗 LinkedIn Profile
                            </a>
                        <?php endif; ?>
                        <?php if ($profile['portfolio']): ?>
                            <a href="<?= htmlspecialchars($profile['portfolio']) ?>" target="_blank" class="link-btn portfolio">
                                🎨 Portfolio
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Remove broken JS for status buttons, let form submit normally
</script>

<?php include '../includes/footer.php'; ?> 