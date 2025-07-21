<?php
require_once '../includes/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM career_resources WHERE id=? AND status='featured'");
$stmt->execute([$id]);
$res = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resource Details - Skillia</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="career-resources-main" style="max-width:900px;margin:40px auto;">
  <a href="career-resources.php" style="color:#b31217;text-decoration:underline;">&larr; Back to Career Resources</a>
  <?php if ($res): ?>
    <div class="cr-card cr-resource-card" style="margin-top:32px;width:100%;max-width:100%;box-sizing:border-box;padding:48px 32px 64px 32px;min-height:700px;">
      <div class="cr-resource-img"><img src="<?= htmlspecialchars($res['icon']) ?>" alt="<?= htmlspecialchars($res['title']) ?>" style="max-width:100%;height:auto;" /></div>
      <h2 class="cr-resource-title" style="margin-top:18px;"><?= htmlspecialchars($res['title']) ?></h2>
      <p class="cr-resource-desc" style="margin:18px 0;"><?= htmlspecialchars($res['description']) ?></p>
      <?php if (!empty($res['content'])): ?>
        <div class="cr-resource-content" style="margin:18px 0;white-space:pre-line;font-size:1.1em;line-height:1.7;max-width:100%;"> <?= nl2br(htmlspecialchars($res['content'])) ?> </div>
      <?php endif; ?>
      <?php if (!empty($res['position'])): ?><div class="cr-resource-tag">Position: <?= htmlspecialchars($res['position']) ?></div><?php endif; ?>
    </div>
  <?php else: ?>
    <div style="padding:2rem;color:#b31217;">Resource not found.</div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 