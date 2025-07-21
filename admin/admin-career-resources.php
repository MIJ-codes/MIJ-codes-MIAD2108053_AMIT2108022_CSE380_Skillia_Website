<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Career Resources - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <style>.admin-nav { margin-bottom: 32px; }</style>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Career Resources</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-users.php">Manage Users</a>
            <a href="admin-jobs.php">Manage Jobs</a>
            <a href="admin-applications.php">Manage Applications</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-career-resources">
        <p>Career resources management coming soon.</p>
    </div>
</div>
</body>
</html> 