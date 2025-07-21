<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Applications - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <style>.admin-nav { margin-bottom: 32px; }</style>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Applications</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-users.php">Manage Users</a>
            <a href="admin-jobs.php">Manage Jobs</a>
            <a href="admin-career-resources.php">Manage Career Resources</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-applications">
        <?php
        // Handle status update
        if (isset($_POST['update_status_id'], $_POST['new_status'])) {
            $app_id = (int)$_POST['update_status_id'];
            $new_status = $_POST['new_status'];
            if (in_array($new_status, ['pending', 'accepted', 'rejected'])) {
                $stmt = $pdo->prepare('UPDATE applications SET status = ? WHERE id = ?');
                $stmt->execute([$new_status, $app_id]);
                echo '<div class="admin-message" style="color:#7c4dff;">Status updated.</div>';
            }
        }
        // Handle delete
        if (isset($_POST['delete_app_id'])) {
            $app_id = (int)$_POST['delete_app_id'];
            $pdo->prepare('DELETE FROM interviews WHERE application_id = ?')->execute([$app_id]);
            $pdo->prepare('DELETE FROM applications WHERE id = ?')->execute([$app_id]);
            echo '<div class="admin-message" style="color:#ff7043;">Application deleted.</div>';
        }
        // Search/filter
        $search = trim($_GET['search'] ?? '');
        $status_filter = $_GET['status'] ?? '';
        $where = [];
        $params = [];
        if ($search !== '') {
            $where[] = '(u.name LIKE :search OR u.email LIKE :search OR j.title LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        if ($status_filter !== '' && in_array($status_filter, ['pending', 'accepted', 'rejected'])) {
            $where[] = 'a.status = :status';
            $params[':status'] = $status_filter;
        }
        $sql = 'SELECT a.*, j.title AS job_title, j.location, j.salary, e.company_name, u.name AS applicant_name, u.email AS applicant_email
                FROM applications a
                JOIN jobs j ON a.job_id = j.id
                JOIN employers e ON j.employer_id = e.id
                JOIN job_seekers js ON a.seeker_id = js.id
                JOIN users u ON js.user_id = u.id';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY a.applied_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $applications = $stmt->fetchAll();
        ?>
        <form method="get" class="admin-form">
            <label for="search">Search</label>
            <input type="text" id="search" name="search" placeholder="Applicant, Email, or Job Title" value="<?= htmlspecialchars($search) ?>">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All</option>
                <option value="pending" <?= $status_filter==='pending'?'selected':'' ?>>Pending</option>
                <option value="accepted" <?= $status_filter==='accepted'?'selected':'' ?>>Accepted</option>
                <option value="rejected" <?= $status_filter==='rejected'?'selected':'' ?>>Rejected</option>
            </select>
            <button type="submit" class="admin-action-btn">Search</button>
        </form>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Applicant</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Employer</th>
                    <th>Status</th>
                    <th>Applied At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?= $app['id'] ?></td>
                    <td><?= htmlspecialchars($app['applicant_name']) ?></td>
                    <td><?= htmlspecialchars($app['applicant_email']) ?></td>
                    <td><?= htmlspecialchars($app['job_title']) ?></td>
                    <td><?= htmlspecialchars($app['company_name']) ?></td>
                    <td class="status-<?= htmlspecialchars($app['status']) ?>">
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="update_status_id" value="<?= $app['id'] ?>">
                            <select name="new_status" onchange="this.form.submit()" class="admin-action-btn" style="min-width:90px;">
                                <option value="pending" <?= $app['status']==='pending'?'selected':'' ?>>Pending</option>
                                <option value="accepted" <?= $app['status']==='accepted'?'selected':'' ?>>Accepted</option>
                                <option value="rejected" <?= $app['status']==='rejected'?'selected':'' ?>>Rejected</option>
                            </select>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($app['applied_at']) ?></td>
                    <td>
                        <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.');">
                            <input type="hidden" name="delete_app_id" value="<?= $app['id'] ?>">
                            <button type="submit" class="admin-action-btn delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty($applications)): ?>
            <div style="padding:1.5rem; color:#888;">No applications found.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html> 