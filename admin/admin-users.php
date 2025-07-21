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
    <title>Manage Users - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Users</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-jobs.php">Manage Jobs</a>
            <a href="admin-applications.php">Manage Applications</a>
            <a href="admin-success-stories.php">Manage Success Stories</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-users">
        <form method="get" class="admin-form">
            <input type="hidden" name="tab" value="users">
            <label for="search_user">Search</label>
            <input type="text" id="search_user" name="search_user" placeholder="Name or Email" value="<?= htmlspecialchars($_GET['search_user'] ?? '') ?>">
            <label for="filter_type">User Type</label>
            <select id="filter_type" name="filter_type">
                <option value="">All</option>
                <option value="jobseeker" <?= (($_GET['filter_type'] ?? '')==='jobseeker')?'selected':'' ?>>Jobseeker</option>
                <option value="employer" <?= (($_GET['filter_type'] ?? '')==='employer')?'selected':'' ?>>Employer</option>
                <option value="admin" <?= (($_GET['filter_type'] ?? '')==='admin')?'selected':'' ?>>Admin</option>
            </select>
            <button type="submit" class="admin-action-btn">Search</button>
        </form>
        <?php
        // Handle delete
        if (isset($_POST['delete_user_id'])) {
            $del_id = (int)$_POST['delete_user_id'];
            // Prevent self-delete for admin
            if (isset($_SESSION['admin_id']) && $del_id == $_SESSION['admin_id']) {
                echo '<div class="admin-message" style="color:#ff7043;">You cannot delete your own admin account.</div>';
            } else {
                // Delete as employer (jobs, applications to those jobs, interviews)
                $employerId = $pdo->prepare('SELECT id FROM employers WHERE user_id = ?');
                $employerId->execute([$del_id]);
                $emp = $employerId->fetch();
                if ($emp) {
                    $empId = $emp['id'];
                    $pdo->exec("DELETE FROM interviews WHERE application_id IN (SELECT id FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE employer_id = $empId))");
                    $pdo->exec("DELETE FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE employer_id = $empId)");
                    $pdo->exec("DELETE FROM jobs WHERE employer_id = $empId");
                    $pdo->exec("DELETE FROM employers WHERE id = $empId");
                }
                // Delete as job seeker (applications, interviews)
                $seekerId = $pdo->prepare('SELECT id FROM job_seekers WHERE user_id = ?');
                $seekerId->execute([$del_id]);
                $seeker = $seekerId->fetch();
                if ($seeker) {
                    $jsId = $seeker['id'];
                    $pdo->exec("DELETE FROM interviews WHERE job_seeker_id = $jsId");
                    $pdo->exec("DELETE FROM applications WHERE seeker_id = $jsId");
                    $pdo->exec("DELETE FROM job_seekers WHERE id = $jsId");
                }
                $pdo->exec("DELETE FROM users WHERE id = $del_id");
                echo '<div class="admin-message" style="color:#7c4dff;">User deleted.</div>';
            }
        }
        // Handle user update
        if (
            isset($_POST['edit_user_id'], $_POST['edit_name'], $_POST['edit_email'], $_POST['edit_type'])
        ) {
            $edit_id = (int)$_POST['edit_user_id'];
            $edit_name = trim($_POST['edit_name']);
            $edit_email = trim($_POST['edit_email']);
            $edit_type = trim($_POST['edit_type']);
            $edit_pass = isset($_POST['edit_password']) ? $_POST['edit_password'] : '';
            if ($edit_pass !== '') {
                $hashed = password_hash($edit_pass, PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET name=?, email=?, user_type=?, password=? WHERE id=?')
                    ->execute([$edit_name, $edit_email, $edit_type, $hashed, $edit_id]);
            } else {
                $pdo->prepare('UPDATE users SET name=?, email=?, user_type=? WHERE id=?')
                    ->execute([$edit_name, $edit_email, $edit_type, $edit_id]);
            }
            echo '<div class="admin-message" style="color:#7c4dff;">User updated.</div>';
        }
        // Build query
        $where = [];
        $params = [];
        if (!empty($_GET['search_user'])) {
            $where[] = '(name LIKE :search OR email LIKE :search)';
            $params[':search'] = '%' . $_GET['search_user'] . '%';
        }
        if (!empty($_GET['filter_type'])) {
            $where[] = 'user_type = :type';
            $params[':type'] = $_GET['filter_type'];
        }
        $sql = 'SELECT id, name, email, user_type, created_at FROM users';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY created_at DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $users = $stmt->fetchAll();
        ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <?php if (isset($_POST['edit_user_id']) && $_POST['edit_user_id'] == $user['id']): ?>
                <tr class="admin-edit-row">
                    <form method="post">
                        <td><?= $user['id'] ?><input type="hidden" name="edit_user_id" value="<?= $user['id'] ?>"></td>
                        <td><input type="text" name="edit_name" value="<?= htmlspecialchars($user['name']) ?>" required></td>
                        <td><input type="email" name="edit_email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
                        <td>
                            <select name="edit_type">
                                <option value="jobseeker" <?= $user['user_type']==='jobseeker'?'selected':'' ?>>Jobseeker</option>
                                <option value="employer" <?= $user['user_type']==='employer'?'selected':'' ?>>Employer</option>
                                <option value="admin" <?= $user['user_type']==='admin'?'selected':'' ?>>Admin</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <div class="admin-action-stack admin-action-stack-edit">
                                <input type="password" name="edit_password" placeholder="New Password (leave blank to keep)" style="width:100%;margin-bottom:10px;">
                                <button type="submit" class="admin-action-btn edit">Save</button>
                                <a href="admin-users.php" class="admin-action-btn delete">Cancel</a>
                            </div>
                        </td>
                    </form>
                </tr>
                <?php else: ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['user_type']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td>
                        <div class="admin-action-stack">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="edit_user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="admin-action-btn edit">Edit</button>
                            </form>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user and all related data? This action cannot be undone.');">
                                <input type="hidden" name="delete_user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="admin-action-btn delete">Delete</button>
                            </form>
                        </div>
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