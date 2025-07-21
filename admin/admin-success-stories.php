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
    <title>Manage Success Stories - Skillia Admin</title>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>
<body>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Manage Success Stories</h1>
        <div class="admin-nav">
            <a href="admin-dashboard.php">Dashboard</a>
            <a href="admin-users.php">Manage Users</a>
            <a href="admin-applications.php">Manage Applications</a>
            <a href="admin-jobs.php">Manage Jobs</a>
            <a href="manage-admins.php" class="add-admin-btn">Add / Manage Admins</a>
        </div>
    </div>
    <div class="tab-content active" id="tab-success-stories">
        <?php
        // Handle delete
        if (isset($_POST['delete_story_id'])) {
            $story_id = (int)$_POST['delete_story_id'];
            $pdo->prepare('DELETE FROM success_stories WHERE id = ?')->execute([$story_id]);
            echo '<div class="admin-message" style="color:#ff7043;">Success story deleted.</div>';
        }
        // Handle edit
        if (
            isset($_POST['edit_story_id'], $_POST['edit_name'], $_POST['edit_job_title'], $_POST['edit_company'], $_POST['edit_story'], $_POST['edit_image_url'])
        ) {
            $story_id = (int)$_POST['edit_story_id'];
            $name = trim($_POST['edit_name']);
            $job_title = trim($_POST['edit_job_title']);
            $company = trim($_POST['edit_company']);
            $story = trim($_POST['edit_story']);
            $image_url = trim($_POST['edit_image_url']);
            $pdo->prepare('UPDATE success_stories SET name=?, job_title=?, company=?, story=?, image_url=? WHERE id=?')
                ->execute([$name, $job_title, $company, $story, $image_url, $story_id]);
            echo '<div class="admin-message" style="color:#7c4dff;">Success story updated.</div>';
        }
        $stories = $pdo->query('SELECT * FROM success_stories ORDER BY submitted_at DESC')->fetchAll();
        ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Story</th>
                    <th>Image</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($stories as $story): ?>
                <tr>
                    <td><?= $story['id'] ?></td>
                    <td><?= htmlspecialchars($story['name']) ?></td>
                    <td><?= htmlspecialchars($story['job_title']) ?></td>
                    <td><?= htmlspecialchars($story['company']) ?></td>
                    <td style="max-width:180px;overflow:auto;white-space:pre-line;"> <?= nl2br(htmlspecialchars($story['story'])) ?> </td>
                    <td><?php if ($story['image_url']): ?><img src="<?= htmlspecialchars($story['image_url']) ?>" alt="Story Image" style="max-width:60px;max-height:60px;border-radius:8px;"/><?php endif; ?></td>
                    <td><?= htmlspecialchars($story['submitted_at']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="edit_story_id" value="<?= $story['id'] ?>">
                            <button type="submit" class="admin-action-btn edit">Edit</button>
                        </form>
                        <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this success story? This action cannot be undone.');">
                            <input type="hidden" name="delete_story_id" value="<?= $story['id'] ?>">
                            <button type="submit" class="admin-action-btn delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php if (isset($_POST['edit_story_id']) && $_POST['edit_story_id'] == $story['id']): ?>
                <tr class="admin-edit-row">
                    <td colspan="8">
                        <form method="post" style="display: flex; flex-wrap: wrap; gap: 18px; align-items: flex-start;">
                            <input type="hidden" name="edit_story_id" value="<?= $story['id'] ?>">
                            <div style="flex:1; min-width:160px;">
                                <label>Name</label>
                                <input type="text" name="edit_name" value="<?= htmlspecialchars($story['name']) ?>" required>
                            </div>
                            <div style="flex:1; min-width:160px;">
                                <label>Job Title</label>
                                <input type="text" name="edit_job_title" value="<?= htmlspecialchars($story['job_title']) ?>" required>
                            </div>
                            <div style="flex:1; min-width:160px;">
                                <label>Company</label>
                                <input type="text" name="edit_company" value="<?= htmlspecialchars($story['company']) ?>" required>
                            </div>
                            <div style="flex:1; min-width:160px;">
                                <label>Image URL</label>
                                <input type="text" name="edit_image_url" value="<?= htmlspecialchars($story['image_url']) ?>">
                            </div>
                            <div style="flex:2; min-width:220px;">
                                <label>Story</label>
                                <textarea name="edit_story" style="width:100%;min-height:40px;resize:vertical;" required><?= htmlspecialchars($story['story']) ?></textarea>
                            </div>
                            <div style="flex-basis:100%; display:flex; gap:12px; margin-top:12px;">
                                <button type="submit" class="admin-action-btn edit">Save</button>
                                <a href="admin-success-stories.php" class="admin-action-btn delete">Cancel</a>
                            </div>
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