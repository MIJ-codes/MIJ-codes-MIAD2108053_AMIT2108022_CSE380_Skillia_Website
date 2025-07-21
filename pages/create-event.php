<?php
session_start();
require_once '../includes/db.php';
// Check if user is logged in and is an employer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header('Location: ../pages/login.php');
    exit;
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $date = $_POST['date'] ?? '';
    $type = trim($_POST['type'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $spots = (int)($_POST['spots'] ?? 0);
    $link = trim($_POST['link'] ?? '');
    if ($title && $desc && $date && $type && $time && $spots > 0) {
        $stmt = $pdo->prepare('INSERT INTO career_events (title, description, date, type, time, spots, link) VALUES (?, ?, ?, ?, ?, ?, ?)');
        if ($stmt->execute([$title, $desc, $date, $type, $time, $spots, $link])) {
            $msg = 'Event created successfully!';
        } else {
            $msg = 'Failed to create event.';
        }
    } else {
        $msg = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Event - Skillia</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="career-resources-main" style="max-width:700px;margin:40px auto;">
  <a href="career-resources.php" style="color:#b31217;text-decoration:underline;">&larr; Back to Career Resources</a>
  <h2 style="margin-top:24px;">Create New Event</h2>
  <?php if ($msg): ?><div class="admin-message" style="margin-bottom:10px;"> <?= htmlspecialchars($msg) ?> </div><?php endif; ?>
  <form method="post" style="margin-top:24px;">
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" required />
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" id="date" name="date" required />
    </div>
    <div class="form-group">
      <label for="type">Type</label>
      <input type="text" id="type" name="type" required placeholder="Webinar, Workshop, etc." />
    </div>
    <div class="form-group">
      <label for="time">Time</label>
      <input type="text" id="time" name="time" required placeholder="e.g. 2:00 PM EST" />
    </div>
    <div class="form-group">
      <label for="spots">Spots</label>
      <input type="number" id="spots" name="spots" min="1" required />
    </div>
    <div class="form-group">
      <label for="link">External Registration Link (optional)</label>
      <input type="url" id="link" name="link" placeholder="https://..." />
    </div>
    <button type="submit" class="cr-event-btn">Create Event</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 