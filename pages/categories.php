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
            <div class="categories-search-bar">
                <input type="text" class="categories-search-input" placeholder="Search categories...">
                <select class="categories-filter" data-type="location">
                    <option value="">All Locations</option>
                    <option value="remote">Remote</option>
                    <option value="onsite">On-site</option>
                    <option value="hybrid">Hybrid</option>
                </select>
                <select class="categories-filter" data-type="experience">
                    <option value="">All Experience Levels</option>
                    <option value="entry">Entry Level</option>
                    <option value="mid">Mid Level</option>
                    <option value="senior">Senior Level</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Filter & Sort Section -->
    <section class="categories-filter-section">
        <div class="categories-filters">
            <button class="categories-filter-btn active">All Categories</button>
            <button class="categories-filter-btn">Most Popular</button>
            <button class="categories-filter-btn">Remote Available</button>
            <button class="categories-filter-btn">Freelance</button>
            <button class="categories-filter-btn">Full-time</button>
        </div>
        <div class="categories-sort">
            <span>Sort by:</span>
            <select class="categories-sort-select">
                <option value="az">A-Z</option>
                <option value="job-count">Job Count</option>
                <option value="salary">Salary Range</option>
            </select>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <div class="categories-grid">
            <?php
            // Fetch all categories with job counts
            require_once '../includes/db.php';
            $sql = "SELECT c.*, COUNT(j.id) AS job_count FROM categories c LEFT JOIN jobs j ON c.id = j.category_id GROUP BY c.id ORDER BY c.name ASC";
            $stmt = $pdo->query($sql);
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
                    // Optionally, add roles and salary if you store them in the DB
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

    <!-- Trending Categories Section (placeholder for backend) -->
    <section class="categories-trending-section">
        <h2>Trending Categories</h2>
        <!-- Future: Loop through trending categories from backend here -->
        <div class="categories-trending-list">
            <!-- Example trending category -->
            <div class="trending-category-card">
                <span class="trending-category-name">AI Services</span>
                <span class="trending-growth">+18% this month</span>
                <span class="category-badge hot">🔥 Hot Category</span>
            </div>
            <!-- ...more trending categories... -->
        </div>
        <div class="categories-trending-note">New jobs added daily</div>
    </section>

    <!-- Quick Actions & Career Resources Section (placeholder for backend) -->
    <section class="categories-actions-section">
        <div class="categories-actions-grid">
            <div class="categories-action-card">
                <h3>Create Job Alert</h3>
                <p>Get notified when new jobs are posted in your favorite categories.</p>
                <a href="job-alerts.php" class="categories-action-btn">Set Job Alert</a>
            </div>
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
        </div>
        <div class="categories-career-resources">
            <h3><a href="career-resources.php" style="color:inherit;text-decoration:underline;">Career Resources</a></h3>
            <ul>
                <li>Skills in Demand by Category</li>
                <li>Career Transition Guides</li>
                <li>Certification Recommendations</li>
            </ul>
        </div>
    </section>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/categories.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 