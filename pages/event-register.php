<?php
require_once '../includes/db.php';
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$event = $pdo->prepare('SELECT * FROM career_events WHERE id=?');
$event->execute([$event_id]);
$event = $event->fetch();

$msg = '';
if ($event && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Please enter a valid name and email.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM career_event_registrations WHERE event_id=? AND email=?');
        $stmt->execute([$event_id, $email]);
        if ($stmt->fetch()) {
            $msg = 'You have already registered for this event.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO career_event_registrations (event_id, name, email) VALUES (?, ?, ?)');
            if ($stmt->execute([$event_id, $name, $email])) {
                $msg = 'Registration successful! Check your email for event details.';
            } else {
                $msg = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register for Event - Skillia</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="career-resources-main" style="max-width:700px;margin:40px auto;">
  <a href="career-resources.php" style="color:#b31217;text-decoration:underline;">&larr; Back to Career Resources</a>
  <?php if ($event): ?>
    <div class="cr-card cr-event-card" style="margin-top:32px;">
      <div class="cr-event-date">
        <span class="cr-event-month"><?= strtoupper(date('M', strtotime($event['date']))) ?></span>
        <span class="cr-event-day"><?= date('d', strtotime($event['date'])) ?></span>
        <span class="cr-event-year"><?= date('Y', strtotime($event['date'])) ?></span>
      </div>
      <div class="cr-event-content">
        <span class="cr-event-type"><?= htmlspecialchars($event['type']) ?></span>
        <h3 class="cr-event-title"><?= htmlspecialchars($event['title']) ?></h3>
        <p class="cr-event-desc"><?= htmlspecialchars($event['description']) ?></p>
        <div class="cr-event-details">
          <span><i class="ri-time-line"></i> <?= htmlspecialchars($event['time']) ?></span>
          <span><i class="ri-user-line"></i> <?= htmlspecialchars($event['spots']) ?> spots</span>
        </div>
      </div>
    </div>
    <form method="post" style="margin-top:32px;">
      <h3>Register for this Event</h3>
      <?php if ($msg): ?><div class="admin-message" style="margin-bottom:10px;"> <?= htmlspecialchars($msg) ?> </div><?php endif; ?>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <button type="submit" class="cr-event-btn">Register</button>
    </form>
  <?php else: ?>
    <div style="padding:2rem;color:#b31217;">Event not found.</div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 