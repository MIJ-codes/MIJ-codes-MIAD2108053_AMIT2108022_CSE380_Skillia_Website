<?php
require_once '../includes/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM career_articles WHERE id=?");
$stmt->execute([$id]);
$art = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Article Details - Skillia</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="career-resources-main" style="max-width:700px;margin:40px auto;">
  <a href="career-resources.php" style="color:#b31217;text-decoration:underline;">&larr; Back to Career Resources</a>
  <?php if ($art): ?>
    <div class="cr-card cr-article-card" style="margin-top:32px;">
      <div class="cr-article-img"><img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars($art['title']) ?>" style="max-width:100%;height:auto;" /></div>
      <div class="cr-article-meta" style="margin:12px 0;">
        <span class="cr-article-date"><?= date('M d, Y', strtotime($art['date'])) ?></span>
        <span class="cr-article-category"><?= htmlspecialchars($art['category']) ?></span>
      </div>
      <h2 class="cr-article-title"><?= htmlspecialchars($art['title']) ?></h2>
      <p class="cr-article-desc" style="margin:18px 0;"><?= htmlspecialchars($art['description']) ?></p>
      <?php if (!empty($art['content'])): ?>
        <div class="cr-article-content" style="margin:18px 0;white-space:pre-line;"> <?= nl2br(htmlspecialchars($art['content'])) ?> </div>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div style="padding:2rem;color:#b31217;">Article not found.</div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 