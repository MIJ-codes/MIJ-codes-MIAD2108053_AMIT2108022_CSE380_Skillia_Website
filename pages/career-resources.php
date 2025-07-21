<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';
// Ensure user_name and user_email are always set for logged-in users
if (isset($_SESSION['user_id']) && (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email']))) {
    $stmt = $pdo->prepare('SELECT name, email FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
    }
}

// Newsletter form handling
$newsletter_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
    $email = trim($_POST['newsletter_email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)');
        if ($stmt->execute([$email])) {
            $newsletter_msg = 'Thank you for subscribing!';
        } else {
            $newsletter_msg = 'You are already subscribed.';
        }
    } else {
        $newsletter_msg = 'Please enter a valid email address.';
    }
}

// Handle instant event registration
$event_reg_msg = [];
if (isset($_POST['register_event_id'])) {
    $event_id = (int)$_POST['register_event_id'];
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
        $event_reg_msg[$event_id] = 'You must be logged in to register.';
    } else {
        $name = $_SESSION['user_name'];
        $email = $_SESSION['user_email'];
        $stmt = $pdo->prepare('SELECT id FROM career_event_registrations WHERE event_id=? AND email=?');
        $stmt->execute([$event_id, $email]);
        if ($stmt->fetch()) {
            $event_reg_msg[$event_id] = 'You have already registered for this event.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO career_event_registrations (event_id, name, email) VALUES (?, ?, ?)');
            if ($stmt->execute([$event_id, $name, $email])) {
                $event_reg_msg[$event_id] = 'Registration successful! Check your email for event details.';
            } else {
                $event_reg_msg[$event_id] = 'Registration failed. Please try again.';
            }
        }
    }
}

// Fetch categories
$categories = $pdo->query("SELECT * FROM career_resources WHERE status='category' ORDER BY position ASC")->fetchAll();

// Fetch featured resources (filter by category_id if set)
$resource_category = $_GET['category'] ?? '';
if ($resource_category) {
    $cat = $pdo->prepare("SELECT id FROM career_resources WHERE status='category' AND title=?");
    $cat->execute([$resource_category]);
    $cat_row = $cat->fetch();
    $cat_id = $cat_row ? $cat_row['id'] : null;
    if ($cat_id) {
        $resources = $pdo->prepare("SELECT * FROM career_resources WHERE status='featured' AND category_id=? ORDER BY position ASC");
        $resources->execute([$cat_id]);
        $resources = $resources->fetchAll();
    } else {
        $resources = [];
    }
} else {
    $resources = $pdo->query("SELECT * FROM career_resources WHERE status='featured' ORDER BY position ASC")->fetchAll();
}

// Fetch articles (optionally filter by category)
$article_category = $_GET['category'] ?? '';
if ($article_category) {
    $articles = $pdo->prepare("SELECT * FROM career_articles WHERE category=? ORDER BY date DESC");
    $articles->execute([$article_category]);
    $articles = $articles->fetchAll();
} else {
    $articles = $pdo->query("SELECT * FROM career_articles ORDER BY date DESC")->fetchAll();
}

// Fetch events
$events = $pdo->query("SELECT * FROM career_events ORDER BY date ASC")->fetchAll();

// Remove the entire FAQ section and its related code
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Career Resources</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/career-resources.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<!-- Floating Background Shapes -->
<div class="floating-shapes">
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
  <div class="floating-shape"></div>
</div>

<?php include '../includes/header.php'; ?>

<div class="career-resources-main">
  <!-- Hero Section (static) -->
  <section class="cr-hero-section">
    <div class="cr-hero-content">
      <h1 class="cr-hero-title">Career Resources</h1>
      <p class="cr-hero-subtitle">Expert tips, guides, and resources to help you grow your career</p>
    </div>
    <div class="animated-blossoms">
      <span></span><span></span><span></span><span></span><span></span>
    </div>
  </section>

  <!-- Categories Section (dynamic) -->
  <section class="cr-categories-section">
    <h2 class="cr-section-title">Resource Categories</h2>
    <div style="max-width:900px;margin:0 auto 32px auto;text-align:center;font-size:1.15em;color:#7b1fa2;">
      Explore expert guides, tools, and articles to help you grow your career. Learn how to build your personal brand, achieve work-life balance, and access resources for every stage of your professional journey.
    </div>
    <div class="cr-grid">
      <?php foreach ($categories as $cat): ?>
        <div class="cr-card cr-category-card" style="cursor:default;">
          <div class="cr-category-icon"><i class="<?= htmlspecialchars($cat['icon']) ?>"></i></div>
          <h3 class="cr-category-title"> <?= htmlspecialchars($cat['title']) ?> </h3>
          <p class="cr-category-desc">
            <?php if ($cat['title'] === 'Personal Branding'): ?>
              Learn how to present yourself professionally, both online and offline. Discover tips for building a strong reputation, networking, and showcasing your unique strengths to employers and peers.
            <?php elseif ($cat['title'] === 'Work-Life Balance'): ?>
              Find strategies and resources to help you manage stress, set boundaries, and maintain a healthy balance between your work and personal life. Improve your productivity and well-being.
            <?php else: ?>
              <?= htmlspecialchars($cat['description']) ?>
            <?php endif; ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Featured Resources Section (dynamic) -->
  <section class="cr-featured-section">
    <h2 class="cr-section-title">Featured Resources<?= $resource_category ? ' - ' . htmlspecialchars($resource_category) : '' ?></h2>
    <div class="cr-grid">
      <?php foreach ($resources as $res): ?>
        <div class="cr-card cr-resource-card">
          <div class="cr-resource-img">
            <img src="<?= htmlspecialchars($res['icon']) ?>" alt="<?= htmlspecialchars($res['title']) ?>" />
          </div>
          <span class="cr-resource-tag"><?= $res['position'] == 1 ? 'Popular' : ($res['position'] == 2 ? 'New' : 'Featured') ?></span>
          <h3 class="cr-resource-title"><?= htmlspecialchars($res['title']) ?></h3>
          <p class="cr-resource-desc"><?= htmlspecialchars($res['description']) ?></p>
          <a href="resource-details.php?id=<?= $res['id'] ?>" class="cr-resource-link">Learn More</a>
        </div>
      <?php endforeach; ?>
      <?php if (empty($resources)): ?>
        <div style="padding:1.5rem; color:#888;">No resources found for this category.</div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Latest Articles Section (dynamic) -->
  <section class="cr-articles-section">
    <h2 class="cr-section-title">Latest Articles<?= $article_category ? ' - ' . htmlspecialchars($article_category) : '' ?></h2>
    <div class="cr-grid">
      <?php foreach ($articles as $art): ?>
        <div class="cr-card cr-article-card">
          <div class="cr-article-img">
            <img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars($art['title']) ?>" />
          </div>
          <div class="cr-article-meta">
            <span class="cr-article-date"><?= date('M d, Y', strtotime($art['date'])) ?></span>
            <span class="cr-article-category"><?= htmlspecialchars($art['category']) ?></span>
          </div>
          <h3 class="cr-article-title"><?= htmlspecialchars($art['title']) ?></h3>
          <p class="cr-article-desc"><?= htmlspecialchars($art['description']) ?></p>
          <a href="article-details.php?id=<?= $art['id'] ?>" class="cr-article-link">Read More</a>
        </div>
      <?php endforeach; ?>
      <?php if (empty($articles)): ?>
        <div style="padding:1.5rem; color:#888;">No articles found for this category.</div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Career Tools Section (static) -->
  <section class="cr-tools-section">
    <h2 class="cr-section-title">Career Tools</h2>
    <div class="cr-grid">
      <div class="cr-card cr-tool-card">
        <div class="cr-tool-icon"><i class="ri-calculator-line"></i></div>
        <h3 class="cr-tool-title">Salary Calculator</h3>
        <p class="cr-tool-desc">Calculate your worth based on experience, location, and skills</p>
        <a href="salary-guide.php" class="cr-tool-btn">Calculate Salary</a>
      </div>
      <div class="cr-card cr-tool-card">
        <div class="cr-tool-icon"><i class="ri-search-line"></i></div>
        <h3 class="cr-tool-title">Job Matcher</h3>
        <p class="cr-tool-desc">Find jobs that perfectly match your skills and preferences</p>
        <a href="job-board.php" class="cr-tool-btn">Find Jobs</a>
      </div>
    </div>
  </section>

  <!-- Events Section (dynamic) -->
  <section class="cr-events-section">
    <h2 class="cr-section-title">Upcoming Events</h2>
    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employer'): ?>
      <div style="text-align:right; margin-bottom: 18px;">
        <a href="create-event.php" class="cr-event-btn" style="background:#b31217;color:#fff;padding:10px 24px;border-radius:24px;font-size:1em;text-decoration:none;">+ Create Event</a>
      </div>
    <?php endif; ?>
    <div class="cr-grid">
      <?php foreach ($events as $event): ?>
        <div class="cr-card cr-event-card">
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
            <?php if (isset($_SESSION['user_id'])): ?>
              <form method="post" style="margin-top:12px;display:inline;">
                <input type="hidden" name="register_event_id" value="<?= $event['id'] ?>">
                <button type="submit" class="cr-event-btn">Register Now</button>
              </form>
              <?php if (!empty($event_reg_msg[$event['id']])): ?>
                <div class="admin-message" style="margin-top:8px;"> <?= htmlspecialchars($event_reg_msg[$event['id']]) ?> </div>
              <?php endif; ?>
            <?php else: ?>
              <a href="login.php" class="cr-event-btn">Login to Register</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($events)): ?>
        <div style="padding:1.5rem; color:#888;">No upcoming events.</div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Newsletter Section (dynamic form, static text) -->
  <section class="cr-newsletter-section">
    <div class="cr-newsletter-container">
      <div class="cr-newsletter-content">
        <h3 class="cr-newsletter-title">Stay Updated</h3>
        <p class="cr-newsletter-desc">Get the latest career tips and resources delivered to your inbox</p>
        <?php if ($newsletter_msg): ?><div class="admin-message" style="margin-bottom:10px;"> <?= htmlspecialchars($newsletter_msg) ?> </div><?php endif; ?>
        <form class="cr-newsletter-form" method="post" autocomplete="off">
          <input type="email" class="cr-newsletter-input" name="newsletter_email" placeholder="Enter your email" required />
          <button type="submit" class="cr-newsletter-btn">Subscribe</button>
        </form>
        <div class="cr-newsletter-terms">
          <input type="checkbox" id="newsletter-terms" required />
          <label for="newsletter-terms">I agree to receive career resources and updates</label>
        </div>
      </div>
    </div>
  </section>

</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/career-resources.js"></script>
<?php include '../includes/footer.php'; ?>

</body>
</html> 