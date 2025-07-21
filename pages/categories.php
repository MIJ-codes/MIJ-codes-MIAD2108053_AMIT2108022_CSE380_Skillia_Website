<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php $currentPage = 'categories'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillia - Browse Job Categories</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/categories.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="categories-main">
    <!-- Hero Section -->
    <section class="categories-hero-section">
        <div class="categories-hero-content">
            <h1 class="categories-hero-title">Browse Jobs by Category</h1>
            <p class="categories-hero-subtitle">Find your perfect opportunity across creative, technical, and business fields</p>
            <form class="categories-search-bar" method="get" action="">
                <input type="text" name="search" class="categories-search-input" placeholder="Search categories..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="categories-search-btn" aria-label="Search"><i class="ri-search-line"></i></button>
            </form>
        </div>
    </section>

    <!-- Trending Categories Section (dynamic, moved up) -->
    <section class="categories-trending-section">
        <h2>Trending Categories</h2>
        <div class="categories-trending-list">
            <?php
            require_once '../includes/db.php';
            // Trending: top 3 by job count (or by growth if available)
            $sql_trending = "SELECT c.id, c.name, c.icon, COUNT(j.id) AS job_count FROM categories c LEFT JOIN jobs j ON c.id = j.category_id GROUP BY c.id ORDER BY job_count DESC, c.name ASC LIMIT 3";
            $stmt_trending = $pdo->query($sql_trending);
            if ($stmt_trending && $stmt_trending->rowCount() > 0) {
                while ($trend = $stmt_trending->fetch()) {
                    $trend_name = htmlspecialchars($trend['name']);
                    $trend_id = (int)$trend['id'];
                    $trend_job_count = (int)$trend['job_count'];
                    echo '<div class="trending-category-card">';
                    echo '  <a href="job-board.php?category=' . $trend_id . '" class="trending-category-name">' . $trend_name . '</a>';
                    echo '  <span class="trending-growth">' . $trend_job_count . ' jobs</span>';
                    echo '  <span class="category-badge hot">🔥 Hot Category</span>';
                    echo '</div>';
                }
            } else {
                echo '<div>No trending categories found.</div>';
            }
            ?>
        </div>
        <div class="categories-trending-note">New jobs added daily</div>
    </section>

    <!-- Filter & Sort Section -->
    <section class="categories-filter-section">
        <div class="categories-sort" style="margin-left:0;">
            <form method="get" action="" id="sortForm" style="display:inline;">
                <?php if (isset($_GET['search'])): ?>
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                <?php endif; ?>
                <span>Sort by:</span>
                <div class="custom-category-dropdown" tabindex="0" id="sortDropdown">
                    <span class="selected-category" id="selectedSort">
                        <?php
                        $sortLabel = (!isset($_GET['sort']) || $_GET['sort'] === 'az') ? 'A-Z' : 'Job Count';
                        echo $sortLabel;
                        ?>
                    </span>
                    <ul class="category-options" id="sortOptions" style="display:none;">
                        <li data-value="az"<?php if(!isset($_GET['sort']) || $_GET['sort']==='az') echo ' class="selected"'; ?>>A-Z</li>
                        <li data-value="job-count"<?php if(isset($_GET['sort']) && $_GET['sort']==='job-count') echo ' class="selected"'; ?>>Job Count</li>
                    </ul>
                    <input type="hidden" name="sort" id="sortInput" value="<?php echo isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'az'; ?>">
                </div>
            </form>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <div class="categories-grid">
            <?php
            // Build SQL based on search and sort
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'az';
            $where = '';
            $params = [];
            if ($search !== '') {
                $where = "WHERE c.name LIKE :search_name OR c.description LIKE :search_desc";
                $params[':search_name'] = "%$search%";
                $params[':search_desc'] = "%$search%";
            }
            $order = "c.name ASC";
            if ($sort === 'job-count') {
                $order = "job_count DESC, c.name ASC";
            }
            $sql = "SELECT c.*, COUNT(j.id) AS job_count FROM categories c LEFT JOIN jobs j ON c.id = j.category_id ".($where ? $where : '')." GROUP BY c.id ORDER BY $order";
            $stmt = $pdo->prepare($sql);
            if (!empty($params)) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }
            if ($stmt && $stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    $icon = htmlspecialchars($row['icon']);
                    $name = htmlspecialchars($row['name']);
                    $desc = htmlspecialchars($row['description']);
                    $job_count = (int)$row['job_count'];
                    $category_id = (int)$row['id'];
                    $category_slug = strtolower(str_replace([' & ', ' ', '/'], ['-', '-', '-'], $name));
                    echo '<div class="category-card" data-category="' . $category_slug . '" data-job-count="' . $job_count . '">';
                    echo '  <a href="job-board.php?category=' . $category_id . '" style="text-decoration:none;color:inherit;">';
                    echo '    <div class="category-icon"><i class="' . $icon . '"></i></div>';
                    echo '    <div class="category-content">';
                    echo '      <h3>' . $name . '</h3>';
                    echo '      <div class="category-jobs">' . number_format($job_count) . ' jobs available</div>';
                    echo '      <div class="category-desc">' . $desc . '</div>';
                    echo '    </div>';
                    echo '  </a>';
                    echo '</div>';
                }
            } else {
                echo '<div>No categories found.</div>';
            }
            ?>
        </div>
    </section>

    <!-- Quick Actions & Career Resources Section (placeholder for backend) -->
    <section class="categories-actions-section">
        <div class="categories-actions-inner">
            <div class="categories-actions-grid">
                <div class="categories-action-card">
                    <h3>Browse Jobs</h3>
                    <p>Preview sample jobs for each category and see what fits you best.</p>
                    <a href="job-board.php" class="categories-action-btn">Browse Jobs</a>
                </div>
                <div class="categories-action-card">
                    <h3>Salary Calculator</h3>
                    <p>Estimate your earning potential by category and experience level.</p>
                    <a href="salary-guide.php#calculator" class="categories-action-btn">Calculate Salary</a>
                </div>
                <div class="categories-career-resources">
                    <h3>Career Resources</h3>
                    <p>Access expert guides, in-demand skills, and certification tips to advance your career.</p>
                    <a href="career-resources.php" class="categories-action-btn" style="margin-top: 18px;">Explore Resources</a>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/categories.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 