<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/db.php';

// Get user ID
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$user_id) {
    header('Location: admin-dashboard.php?tab=users');
    exit;
}

// Fetch user
$stmt = $pdo->prepare('SELECT id, name, email, user_type FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: admin-dashboard.php?tab=users');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user_type = $_POST['user_type'] ?? '';
    if ($name && $email && in_array($user_type, ['jobseeker','employer','admin'])) {
        $stmt = $pdo->prepare('UPDATE users SET name=?, email=?, user_type=? WHERE id=?');
        $stmt->execute([$name, $email, $user_type, $user_id]);
        $message = 'User updated successfully.';
        // Optionally redirect back
        header('Location: admin-dashboard.php?tab=users&updated=1');
        exit;
    } else {
        $message = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>
<body>
<div class="admin-dashboard">
    <h1>Edit User</h1>
    <?php if ($message): ?>
        <div class="admin-message" style="color:#ff7043;"> <?= htmlspecialchars($message) ?> </div>
    <?php endif; ?>
    <form method="post" class="admin-form">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <label for="user_type">User Type</label>
        <select id="user_type" name="user_type" required>
            <option value="jobseeker" <?= $user['user_type']==='jobseeker'?'selected':'' ?>>Jobseeker</option>
            <option value="employer" <?= $user['user_type']==='employer'?'selected':'' ?>>Employer</option>
            <option value="admin" <?= $user['user_type']==='admin'?'selected':'' ?>>Admin</option>
        </select>
        <button type="submit">Save Changes</button>
        <a href="admin-dashboard.php?tab=users" class="admin-action-btn" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>
</body>
</html> 