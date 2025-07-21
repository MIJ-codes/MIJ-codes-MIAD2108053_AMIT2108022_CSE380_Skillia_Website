<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Home</title>
  <link rel="stylesheet" href="/Skillia/assets/css/home.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="/Skillia/assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div id="main" class="fade-in animated" style="background: var(--bg-light); min-height: 100vh;">
  <div class="floating-shape shape1"></div>
  <div class="floating-shape shape2"></div>
  <div class="floating-shape shape3"></div>
  <div id="page1" style="display: flex; align-items: center; justify-content: center; min-height: 60vh; background: linear-gradient(135deg, #e6fff7 0%, #e6eaff 100%);">
    <div id="block1" style="flex: 1; display: flex; align-items: center; justify-content: center;">
      <div class="container" style="max-width: 600px; margin: 0 auto; background: rgba(255,255,255,0.85); border-radius: 24px; box-shadow: 0 8px 32px rgba(81,45,168,0.10); padding: 48px 32px;">
        <div id="hbox">
          <h1 aria-live="polite">Don't lose your Bela Bose anymore because of jobs.</h1>
        </div>
        <div id="tbox">
          <p>
            Find the best paying jobs from country's biggest job site.<br />From
            thousands of jobs find your perfect match.
          </p>
        </div>
      </div>
    </div>
    <div id="block2" style="flex: 1; display: flex; align-items: center; justify-content: center;">
      <img src="/Skillia/assets/images/first_page_photo.png" alt="Job Search Illustration" style="max-width: 420px; width: 100%; height: auto; box-shadow: 0 8px 32px rgba(81,45,168,0.08); border-radius: 24px;"/>
    </div>
  </div>
  <div id="page2">
    <div id="p2h">
      <h1>Categories</h1>
      <h1><a href="/Skillia/pages/categories.php" style="color:inherit;text-decoration:underline;cursor:pointer;">See all</a></h1>
    </div>
    <div id="cbox">
      <?php
      require_once __DIR__ . '/../includes/db.php';
      $stmt = $pdo->query('
          SELECT c.*, COUNT(j.id) AS job_count
          FROM categories c
          LEFT JOIN jobs j ON c.id = j.category_id
          GROUP BY c.id
          ORDER BY job_count DESC, c.id ASC
          LIMIT 9
      ');
      $categories = $stmt->fetchAll();
      foreach ($categories as $cat): ?>
        <a href="/Skillia/pages/job-board.php?category=<?= $cat['id'] ?>" style="text-decoration:none;color:inherit;">
          <div class="card">
            <div class="category-icon"><i class="<?= htmlspecialchars($cat['icon']) ?>" style="font-size:2.2rem;"></i></div>
            <p><?= htmlspecialchars($cat['name']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div id="popularbox">
      <!-- Removed Popular Services section -->
    </div>
    <!-- Animated Success Counter Section -->
    <?php
    require_once __DIR__ . '/../includes/db.php';
    $jobsCount = $pdo->query('SELECT COUNT(*) FROM jobs')->fetchColumn();
    $hiredCount = $pdo->query('SELECT COUNT(*) FROM applications')->fetchColumn();
    $employersCount = $pdo->query('SELECT COUNT(*) FROM employers')->fetchColumn();
    $seekersCount = $pdo->query('SELECT COUNT(*) FROM job_seekers')->fetchColumn();
    ?>
    <section id="success-counter" style="margin: 60px auto 40px auto; max-width: 900px; background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(81,45,168,0.07); padding: 36px 24px 28px 24px; text-align: center; position:relative; z-index:10;">
      <h2 class="animated-heading" style="color:#512da8;font-size:2rem;margin-bottom:24px;">Skillia in Numbers</h2>
      <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:40px;">
        <div class="counter-block animated-card"><div class="counter-num" data-target="<?= $jobsCount ?>">0</div><div class="counter-label">Jobs Posted</div></div>
        <div class="counter-block animated-card"><div class="counter-num" data-target="<?= $hiredCount ?>">0</div><div class="counter-label">People Hired</div></div>
        <div class="counter-block animated-card"><div class="counter-num" data-target="<?= $employersCount ?>">0</div><div class="counter-label">Active Employers</div></div>
        <div class="counter-block animated-card"><div class="counter-num" data-target="<?= $seekersCount ?>">0</div><div class="counter-label">Active Job Seekers</div></div>
      </div>
    </section>
    <!-- Homepage Call-to-Action -->
    <section id="homepage-cta" style="margin: 40px auto 60px auto; max-width: 700px; background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(81,45,168,0.07); padding: 36px 24px 28px 24px; text-align: center; position:relative; z-index:10;">
      <h2 class="animated-heading" style="color:#512da8;font-size:2rem;margin-bottom:18px;">Get Started in 30 Seconds</h2>
      <p style="font-size:1.15rem;color:#555;margin-bottom:24px;">No account? No problem. Start exploring instantly!</p>
      <div style="display:flex;gap:24px;justify-content:center;flex-wrap:wrap;">
        <a href="/Skillia/pages/job-board.php" class="cta-btn homepage-cta-btn" style="padding:16px 38px;background:linear-gradient(135deg,#7c4dff 0%,#512da8 100%);color:#fff;font-weight:700;font-size:1.1rem;border-radius:12px;text-decoration:none;">Find Jobs Now</a>
        <a href="/Skillia/pages/post-job.php" class="cta-btn homepage-cta-btn" style="padding:16px 38px;background:linear-gradient(135deg,#512da8 0%,#7c4dff 100%);color:#fff;font-weight:700;font-size:1.1rem;border-radius:12px;text-decoration:none;">Post a Job</a>
      </div>
    </section>
  </div>
</div>
<div class="bottom-blob"></div>
<?php include '../includes/footer.php'; ?>
<script>
// Floating particles
(function() {
  const main = document.getElementById('main');
  for (let i = 0; i < 18; i++) {
    const p = document.createElement('div');
    p.className = 'particle-bubble';
    p.style.left = Math.random() * 100 + 'vw';
    p.style.top = Math.random() * 100 + 'vh';
    p.style.width = p.style.height = (16 + Math.random() * 32) + 'px';
    p.style.opacity = 0.08 + Math.random() * 0.12;
    p.style.background = 'radial-gradient(circle, #7fffd4 0%, #b39ddb 80%, transparent 100%)';
    p.style.position = 'absolute';
    p.style.borderRadius = '50%';
    p.style.zIndex = 1;
    main.appendChild(p);
    animateParticle(p);
  }
  function animateParticle(p) {
    const duration = 10 + Math.random() * 10;
    const deltaY = 40 + Math.random() * 60;
    p.animate([
      { transform: 'translateY(0)' },
      { transform: `translateY(-${deltaY}px)` }
    ], {
      duration: duration * 1000,
      direction: 'alternate',
      iterations: Infinity,
      easing: 'ease-in-out'
    });
  }
})();
// Parallax/tilt effect on cards
function addParallax(card) {
  card.addEventListener('mousemove', function(e) {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const cx = rect.width / 2;
    const cy = rect.height / 2;
    const dx = (x - cx) / cx;
    const dy = (y - cy) / cy;
    card.style.transform = `scale(1.06) rotateY(${dx*8}deg) rotateX(${-dy*8}deg)`;
  });
  card.addEventListener('mouseleave', function() {
    card.style.transform = '';
  });
}
document.querySelectorAll('.card, .bigcard').forEach(addParallax);
// Staggered entrance for cards and headings
function staggerIn(selector, delay=120) {
  const els = document.querySelectorAll(selector);
  els.forEach((el, i) => {
    setTimeout(() => {
      el.style.opacity = 1;
      el.style.transform = 'none';
    }, i * delay + 400);
  });
}
staggerIn('.card', 90);
staggerIn('.bigcard', 120);
staggerIn('#p2h h1', 200);
staggerIn('#popularbox h1', 200);
// Enhanced ripple effect on card click
function addRipple(card) {
  card.addEventListener('click', function(e) {
    let ripple = card.querySelector('.ripple');
    if (ripple) ripple.remove();
    ripple = document.createElement('span');
    ripple.className = 'ripple';
    card.appendChild(ripple);
    const d = Math.max(card.offsetWidth, card.offsetHeight);
    ripple.style.width = ripple.style.height = d + 'px';
    ripple.style.left = (e.offsetX - d/2) + 'px';
    ripple.style.top = (e.offsetY - d/2) + 'px';
    ripple.classList.add('ripple-animate');
    setTimeout(() => ripple.remove(), 600);
  });
}
document.querySelectorAll('.card, .bigcard').forEach(addRipple);
// Animated Counter
(function() {
  function animateCounter(el, target, duration = 2000) {
    let start = 0;
    const increment = Math.ceil(target / (duration / 16));
    let current = start;
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = current.toLocaleString();
    }, 16);
  }
  document.querySelectorAll('.counter-num').forEach(el => {
    const target = parseInt(el.getAttribute('data-target'));
    animateCounter(el, target, 1800 + Math.random()*800);
  });
})();
</script>
<style>
.particle-bubble {
  pointer-events: none;
  position: absolute;
  z-index: 1;
  transition: opacity 0.3s;
}
.ripple {
  position: absolute;
  border-radius: 50%;
  background: rgba(81,45,168,0.18);
  transform: scale(0);
  opacity: 0.5;
  pointer-events: none;
  z-index: 10;
  animation: none;
}
.ripple-animate {
  animation: rippleGrow 0.6s linear forwards;
}
@keyframes rippleGrow {
  to {
    transform: scale(2.5);
    opacity: 0;
  }
}
</style>
</body>
</html> 