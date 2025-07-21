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
    <title>Manage Jobs - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <style>
        .admin-nav { margin-bottom: 32px; }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Jobs</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-users.php">Manage Users</a>
            <a href="admin-applications.php">Manage Applications</a>
            <a href="admin-success-stories.php">Manage Success Stories</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-jobs">
        <?php
        // Handle job delete
        if (isset($_POST['delete_job_id'])) {
            $job_id = (int)$_POST['delete_job_id'];
            $pdo->exec("DELETE FROM interviews WHERE job_id = $job_id");
            $pdo->exec("DELETE FROM applications WHERE job_id = $job_id");
            $pdo->exec("DELETE FROM jobs WHERE id = $job_id");
            echo '<div class="admin-message" style="color:#ff7043;">Job deleted.</div>';
        }
        // Handle job update
        if (
            isset($_POST['edit_job_id'], $_POST['edit_title'], $_POST['edit_description'], $_POST['edit_location'], $_POST['edit_salary'])
        ) {
            $job_id = (int)$_POST['edit_job_id'];
            $title = trim($_POST['edit_title']);
            $desc = trim($_POST['edit_description']);
            $loc = trim($_POST['edit_location']);
            $salary = trim($_POST['edit_salary']);
            $pdo->prepare('UPDATE jobs SET title=?, description=?, location=?, salary=? WHERE id=?')
                ->execute([$title, $desc, $loc, $salary, $job_id]);
            echo '<div class="admin-message" style="color:#7c4dff;">Job updated.</div>';
        }
        $sql = 'SELECT jobs.*, employers.company_name FROM jobs JOIN employers ON jobs.employer_id = employers.id ORDER BY jobs.created_at DESC';
        $jobs = $pdo->query($sql)->fetchAll();
        ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $job): ?>
                <?php if (isset($_POST['edit_job_id']) && $_POST['edit_job_id'] == $job['id']): ?>
                <tr class="admin-edit-row">
                    <form method="post">
                        <td><?= $job['id'] ?><input type="hidden" name="edit_job_id" value="<?= $job['id'] ?>"></td>
                        <td><input type="text" name="edit_title" value="<?= htmlspecialchars($job['title']) ?>" required></td>
                        <td><?= htmlspecialchars($job['company_name']) ?></td>
                        <td><input type="text" name="edit_location" value="<?= htmlspecialchars($job['location']) ?>" required></td>
                        <td><input type="text" name="edit_salary" value="<?= htmlspecialchars($job['salary']) ?>" required></td>
                        <td><?= htmlspecialchars($job['created_at']) ?></td>
                        <td>
                            <textarea name="edit_description" placeholder="Description" style="width:120px;min-height:40px;resize:vertical;"><?= htmlspecialchars($job['description']) ?></textarea>
                            <button type="submit" class="admin-action-btn edit">Save</button>
                            <a href="admin-jobs.php" class="admin-action-btn delete">Cancel</a>
                        </td>
                    </form>
                </tr>
                <?php else: ?>
                <tr>
                    <td><?= $job['id'] ?></td>
                    <td><?= htmlspecialchars($job['title']) ?></td>
                    <td><?= htmlspecialchars($job['company_name']) ?></td>
                    <td><?= htmlspecialchars($job['location']) ?></td>
                    <td><?= htmlspecialchars($job['salary']) ?></td>
                    <td><?= htmlspecialchars($job['created_at']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="edit_job_id" value="<?= $job['id'] ?>">
                            <button type="submit" class="admin-action-btn edit">Edit</button>
                        </form>
                        <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this job and all related applications/interviews? This action cannot be undone.');">
                            <input type="hidden" name="delete_job_id" value="<?= $job['id'] ?>">
                            <button type="submit" class="admin-action-btn delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html> 