<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Admins</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-jobs.php">Manage Jobs</a>
            <a href="admin-applications.php">Manage Applications</a>
            <a href="admin-career-resources.php">Manage Career Resources</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-admins">
        <?php
        // Handle search
        $search_admin = trim($_GET['search_admin'] ?? '');
        $where = [];
        $params = [];
        if ($search_admin !== '') {
            $where[] = 'username LIKE :search';
            $params[':search'] = '%' . $search_admin . '%';
        }
        $sql = 'SELECT id, username, created_at FROM admins';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $admins = $stmt->fetchAll();

        // Handle add admin
        $add_error = '';
        $add_success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
            $new_username = trim($_POST['username'] ?? '');
            $new_password = $_POST['password'] ?? '';
            if ($new_username === '' || $new_password === '') {
                $add_error = 'Username and password are required.';
            } else {
                $stmt2 = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
                $stmt2->execute([$new_username]);
                if ($stmt2->fetch()) {
                    $add_error = 'Username already exists.';
                } else {
                    $hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt2 = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
                    if ($stmt2->execute([$new_username, $hash])) {
                        $add_success = 'Admin added successfully!';
                    } else {
                        $add_error = 'Error adding admin.';
                    }
                }
            }
        }
        // Handle delete
        if (isset($_POST['delete_admin_id'])) {
            $del_id = (int)$_POST['delete_admin_id'];
            // Prevent self-delete
            if (isset($_SESSION['admin_id']) && $del_id == $_SESSION['admin_id']) {
                echo '<div class="admin-message" style="color:#ff7043;">You cannot delete your own admin account.</div>';
            } else {
                $pdo->prepare('DELETE FROM admins WHERE id = ?')->execute([$del_id]);
                echo '<div class="admin-message" style="color:#7c4dff;">Admin deleted.</div>';
            }
        }
        // Handle edit
        if (
            isset($_POST['edit_admin_id'], $_POST['edit_username'])
        ) {
            $edit_id = (int)$_POST['edit_admin_id'];
            $edit_username = trim($_POST['edit_username']);
            $edit_pass = isset($_POST['edit_password']) ? $_POST['edit_password'] : '';
            if ($edit_pass !== '') {
                $hashed = password_hash($edit_pass, PASSWORD_DEFAULT);
                $pdo->prepare('UPDATE admins SET username=?, password=? WHERE id=?')
                    ->execute([$edit_username, $hashed, $edit_id]);
            } else {
                $pdo->prepare('UPDATE admins SET username=? WHERE id=?')
                    ->execute([$edit_username, $edit_id]);
            }
            echo '<div class="admin-message" style="color:#7c4dff;">Admin updated.</div>';
        }
        ?>
        <form method="get" class="admin-form">
            <label for="search_admin">Search</label>
            <input type="text" id="search_admin" name="search_admin" placeholder="Username" value="<?= htmlspecialchars($search_admin) ?>">
            <button type="submit" class="admin-action-btn">Search</button>
        </form>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($admins as $admin): ?>
                <?php if (isset($_POST['edit_admin_id']) && $_POST['edit_admin_id'] == $admin['id']): ?>
                <tr class="admin-edit-row">
                    <form method="post">
                        <td><?= $admin['id'] ?><input type="hidden" name="edit_admin_id" value="<?= $admin['id'] ?>"></td>
                        <td><input type="text" name="edit_username" value="<?= htmlspecialchars($admin['username']) ?>" required></td>
                        <td><?= htmlspecialchars($admin['created_at']) ?></td>
                        <td>
                            <div class="admin-action-stack admin-action-stack-edit">
                                <input type="password" name="edit_password" placeholder="New Password (leave blank to keep)" style="width:100%;margin-bottom:10px;">
                                <button type="submit" class="admin-action-btn edit">Save</button>
                                <a href="manage-admins.php" class="admin-action-btn delete">Cancel</a>
                            </div>
                        </td>
                    </form>
                </tr>
                <?php else: ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td><?= htmlspecialchars($admin['created_at']) ?></td>
                    <td>
                        <div class="admin-action-stack">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="edit_admin_id" value="<?= $admin['id'] ?>">
                                <button type="submit" class="admin-action-btn edit">Edit</button>
                            </form>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this admin? This action cannot be undone.');">
                                <input type="hidden" name="delete_admin_id" value="<?= $admin['id'] ?>">
                                <button type="submit" class="admin-action-btn delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" autocomplete="off" class="admin-form">
            <h3 style="color:#b31217; margin-bottom:10px;">Add New Admin</h3>
            <?php if ($add_error): ?><div class="admin-message error"><?= htmlspecialchars($add_error) ?></div><?php endif; ?>
            <?php if ($add_success): ?><div class="admin-message success"><?= htmlspecialchars($add_success) ?></div><?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="add_admin" class="admin-action-btn">Add Admin</button>
        </form>
    </div>
</div>
</body>
</html> 