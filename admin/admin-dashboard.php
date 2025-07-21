<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';
// Fetch current admin profile
$admin_id = $_SESSION['admin_id'] ?? null;
$admin = null;
if ($admin_id) {
    $stmt = $pdo->prepare('SELECT id, username, created_at FROM admins WHERE id = ?');
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Skillia</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #fff 0%, #ff69b4 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .dashboard-container {
            max-width: 600px;
            margin: 48px auto 32px auto;
            background: linear-gradient(120deg, #ff5e62 0%, #b31217 100%);
            border-radius: 32px;
            box-shadow: 0 8px 32px 0 rgba(255,105,180,0.13), 0 2px 12px 0 rgba(179,18,23,0.10);
            border: 2px solid #ff69b4;
            padding: 36px 32px 32px 32px;
            color: #fff;
            min-height: 60vh;
            width: 95vw;
            max-width: 600px;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 2.3rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 2px 8px #ff69b4;
        }
        .admin-profile {
            background: #fff;
            color: #b31217;
            border-radius: 24px;
            box-shadow: 0 2px 12px rgba(255,105,180,0.08);
            padding: 28px 24px;
            margin-bottom: 32px;
            text-align: center;
        }
        .admin-profile h2 {
            margin: 0 0 10px 0;
            font-size: 1.4rem;
            color: #b31217;
        }
        .admin-profile .profile-row {
            margin-bottom: 8px;
        }
        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 18px;
            align-items: center;
        }
        .admin-nav a {
            display: block;
            width: 100%;
            max-width: 320px;
            background: linear-gradient(90deg, #ff69b4 0%, #b31217 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 18px;
            padding: 14px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(255,105,180,0.10);
            transition: background 0.2s, color 0.2s, transform 0.18s;
        }
        .admin-nav a:hover {
            background: #fff;
            color: #b31217;
            transform: scale(1.04);
        }
        .add-admin-btn {
            background: linear-gradient(90deg, #b31217 0%, #ff69b4 100%);
            color: #fff;
            margin-top: 18px;
        }
        .add-admin-btn:hover {
            background: #fff;
            color: #b31217;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="admin-profile">
        <h2>Welcome, <?= htmlspecialchars($admin['username'] ?? 'Admin') ?></h2>
        <div class="profile-row"><strong>Admin ID:</strong> <?= htmlspecialchars($admin['id'] ?? '-') ?></div>
        <div class="profile-row"><strong>Joined:</strong> <?= htmlspecialchars($admin['created_at'] ?? '-') ?></div>
    </div>
    <div class="admin-nav">
        <a href="admin-users.php">Manage Users</a>
        <a href="admin-jobs.php">Manage Jobs</a>
        <a href="admin-applications.php">Manage Applications</a>
        <a href="admin-success-stories.php">Manage Success Stories</a>
        <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
    </div>
</div>
</body>
</html> 