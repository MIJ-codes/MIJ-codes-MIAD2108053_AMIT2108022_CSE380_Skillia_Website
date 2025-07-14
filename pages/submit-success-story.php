<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php include '../includes/header.php'; ?>
<link rel="stylesheet" href="/Skillia/assets/css/style.css" />
<link rel="stylesheet" href="/Skillia/assets/css/job-seekers.css" />
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
<div id="main" class="fade-in" style="background: var(--bg-light); min-height: 100vh;">
  <section id="submit-success-story" style="padding: 4rem 0; max-width: 600px; margin: 0 auto;">
    <div class="section-header" style="text-align: center; margin-bottom: 2rem;">
      <h2 class="section-title" style="font-size: 2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1rem;">Share Your Success Story</h2>
      <p class="section-subtitle" style="font-size: 1.1rem; color: var(--text-medium);">Inspire others by sharing how Skillia helped you achieve your career goals.</p>
    </div>
    <div class="story-form-container" style="background: var(--white); border-radius: 16px; box-shadow: 0 8px 32px 0 rgba(81,45,168,0.10); padding: 2rem;">
      <div class="login-required-message" style="color: var(--primary); font-weight: 600; text-align: center; margin-bottom: 1.5rem;">Login required to submit your story. (Feature coming soon!)</div>
      <form method="post" action="#" enctype="multipart/form-data" style="opacity: 0.5; pointer-events: none;">
        <div class="form-group" style="margin-bottom: 1rem;">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" class="form-control" required />
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
          <label for="job_title">Job Title</label>
          <input type="text" id="job_title" name="job_title" class="form-control" required />
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
          <label for="company">Company</label>
          <input type="text" id="company" name="company" class="form-control" required />
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
          <label for="story">Your Story</label>
          <textarea id="story" name="story" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 1.5rem;">
          <label for="image">Photo (optional)</label>
          <input type="file" id="image" name="image" class="form-control" accept="image/*" />
        </div>
        <button type="submit" class="cta-btn primary" style="width: 100%;">Submit Story</button>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?> 