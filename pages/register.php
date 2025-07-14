<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';
include '../includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $user_type = $_POST['user_type'] ?? '';

    if ($name && $email && $password && in_array($user_type, ['jobseeker', 'employer'])) {
        // Check if email already exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = 'Email already registered.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $now = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $hashed, $user_type, $now, $now]);
            $user_id = $pdo->lastInsertId();
            // Create profile row
            if ($user_type === 'jobseeker') {
                $pdo->prepare('INSERT INTO job_seekers (user_id) VALUES (?)')->execute([$user_id]);
            } else {
                $pdo->prepare('INSERT INTO employers (user_id) VALUES (?)')->execute([$user_id]);
            }
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = $user_type;
            header('Location: ../pages/' . ($user_type === 'jobseeker' ? 'job-seeker-dashboard.php' : 'employer-dashboard.php'));
            exit;
        }
    } else {
        $message = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Skillia</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/register.css">
  <style>
    .fade-in {
      animation: fadeInUp 0.8s cubic-bezier(.23,1.01,.32,1) both;
    }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(40px); }
      100% { opacity: 1; transform: none; }
    }
  </style>
</head>
<body class="main-bg">
<div id="particles-js"></div>
<div class="centered-card fade-in">
  <div class="register-title">Create an Account</div>
  <?php if ($message): ?>
    <div class="register-message"> <?= htmlspecialchars($message) ?> </div>
  <?php endif; ?>
  <form method="post" autocomplete="off">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
      <label for="user_type">User Type</label>
      <select id="user_type" name="user_type" required>
        <option value="">Select...</option>
        <option value="jobseeker">Job Seeker</option>
        <option value="employer">Employer</option>
      </select>
    </div>
    <button type="submit" class="theme-btn">Register</button>
  </form>
  <div class="login-link">
    Already have an account? <a href="login.php">Login</a>
  </div>
</div>
<script src="../assets/js/particles.js"></script>
<script>
  if (window.particlesJS) {
    particlesJS.load('particles-js', '../assets/js/particles.json', function() {});
  }
</script>
<script src="../assets/js/main.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 