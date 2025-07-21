<?php
require_once '../includes/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT job_seekers.*, users.name, users.email FROM job_seekers JOIN users ON job_seekers.user_id = users.id WHERE job_seekers.id = ?');
$stmt->execute([$id]);
$cand = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Candidate Profile - Skillia</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/search-candidates.css" />
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="search-candidates-main" style="max-width:800px;margin:40px auto;">
  <a href="search-candidates.php" style="color:#b31217;text-decoration:underline;">&larr; Back to Search</a>
  <?php if ($cand): ?>
    <div class="candidate-card" style="margin-top:32px;box-shadow:0 4px 24px #b39ddb33;">
      <div class="candidate-header">
        <div class="candidate-avatar">
          <?php if (!empty($cand['photo'])): ?>
            <img src="<?= htmlspecialchars($cand['photo']) ?>" alt="<?= htmlspecialchars($cand['name']) ?>">
          <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($cand['name']) ?>&background=ded6f7&color=512da8" alt="<?= htmlspecialchars($cand['name']) ?>">
          <?php endif; ?>
        </div>
        <div class="candidate-info">
          <h2><?= htmlspecialchars($cand['name']) ?></h2>
          <p class="candidate-title"> <?= isset($cand['title']) ? htmlspecialchars($cand['title']) : 'N/A' ?> </p>
          <p class="candidate-location"><i class="ri-map-pin-line"></i> <?= isset($cand['location']) ? htmlspecialchars($cand['location']) : 'N/A' ?></p>
        </div>
      </div>
      <div class="candidate-details" style="margin-top:18px;">
        <p><strong>Email:</strong> <?= htmlspecialchars($cand['email']) ?></p>
        <?php if (!empty($cand['skills'])): ?><p><strong>Skills:</strong> <?php foreach (explode(',', $cand['skills']) as $skill): ?><span class="skill-tag" style="margin-right:6px;"> <?= htmlspecialchars(trim($skill)) ?> </span><?php endforeach; ?></p><?php endif; ?>
        <?php if (isset($cand['bio'])): ?><p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($cand['bio'])) ?></p><?php endif; ?>
        <?php if (!empty($cand['resume'])): ?>
          <p><strong>Resume File:</strong> <a href="<?= htmlspecialchars($cand['resume']) ?>" target="_blank">Download/View</a></p>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <div style="padding:2rem;color:#b31217;">Candidate not found.</div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 