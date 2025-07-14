<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';
include '../includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];
            if ($user['user_type'] === 'jobseeker') {
                header('Location: job-seeker-dashboard.php');
            } else {
                header('Location: employer-dashboard.php');
            }
            exit;
        } else {
            $message = 'Invalid email or password.';
        }
    } else {
        $message = 'Please enter both email and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Skillia</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/login.css">
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
  <div class="login-title">Login</div>
  <?php if ($message): ?>
    <div class="login-message"> <?= htmlspecialchars($message) ?> </div>
  <?php endif; ?>
  <form method="post" autocomplete="off">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="theme-btn">Login</button>
  </form>
  <div class="register-link">
    Don't have an account? <a href="register.php">Register</a>
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