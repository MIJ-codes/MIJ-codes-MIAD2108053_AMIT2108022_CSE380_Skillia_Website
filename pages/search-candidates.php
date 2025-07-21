<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';

// Handle search filters
$filters = [
    'jobTitle' => trim($_GET['jobTitle'] ?? ''),
    'location' => trim($_GET['location'] ?? ''),
    'experience' => trim($_GET['experience'] ?? ''),
    'skills' => trim($_GET['skills'] ?? ''),
    'availability' => trim($_GET['availability'] ?? ''),
    'salary' => trim($_GET['salary'] ?? ''),
];
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 12;
$where = [];
$params = [];

// Build SQL WHERE clauses
if ($filters['jobTitle']) {
    $where[] = '(job_seekers.title LIKE ? OR job_seekers.bio LIKE ?)';
    $params[] = '%' . $filters['jobTitle'] . '%';
    $params[] = '%' . $filters['jobTitle'] . '%';
}
if ($filters['location']) {
    $where[] = 'job_seekers.location = ?';
    $params[] = $filters['location'];
}
if ($filters['experience']) {
    if ($filters['experience'] === 'entry') {
        $where[] = 'job_seekers.experience_years <= 2';
    } elseif ($filters['experience'] === 'mid') {
        $where[] = 'job_seekers.experience_years BETWEEN 3 AND 5';
    } elseif ($filters['experience'] === 'senior') {
        $where[] = 'job_seekers.experience_years > 5';
    }
}
if ($filters['skills']) {
    $skills = array_map('trim', explode(',', $filters['skills']));
    foreach ($skills as $skill) {
        $where[] = 'job_seekers.skills LIKE ?';
        $params[] = '%' . $skill . '%';
    }
}
if ($filters['availability']) {
    $where[] = 'job_seekers.availability = ?';
    $params[] = $filters['availability'];
}
if ($filters['salary']) {
    if ($filters['salary'] === '20k-40k') {
        $where[] = "job_seekers.expected_salary BETWEEN 20000 AND 40000";
    } elseif ($filters['salary'] === '40k-60k') {
        $where[] = "job_seekers.expected_salary BETWEEN 40001 AND 60000";
    } elseif ($filters['salary'] === '60k-80k') {
        $where[] = "job_seekers.expected_salary BETWEEN 60001 AND 80000";
    } elseif ($filters['salary'] === '80k+') {
        $where[] = "job_seekers.expected_salary > 80000";
    }
}

// Count total candidates
$sqlCount = 'SELECT COUNT(*) FROM job_seekers JOIN users ON job_seekers.user_id = users.id';
if ($where) {
    $sqlCount .= ' WHERE ' . implode(' AND ', $where);
}
$stmt = $pdo->prepare($sqlCount);
$stmt->execute($params);
$totalCandidates = (int)$stmt->fetchColumn();

// Fetch candidates
$sql = 'SELECT job_seekers.*, users.name, users.email FROM job_seekers JOIN users ON job_seekers.user_id = users.id';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$offset = ($page-1)*$perPage;
$sql .= " ORDER BY job_seekers.updated_at DESC LIMIT $offset, $perPage";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$candidates = $stmt->fetchAll();
$totalPages = max(1, ceil($totalCandidates / $perPage));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Candidates - Skillia</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/search-candidates.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="search-candidates-main">
    <section class="search-candidates-hero-section">
        <div class="search-candidates-hero-bg">
            <!-- Magnifying glass shapes -->
            <div class="search-magnifier-1"></div>
            <div class="search-magnifier-2"></div>
            
            <!-- User profile shapes -->
            <div class="user-profile-1"></div>
            <div class="user-profile-2"></div>
            
            <!-- Data stream lines -->
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            
            <!-- Floating search icons -->
            <span class="search-icon-1"><i class="ri-search-line"></i></span>
            <span class="search-icon-2"><i class="ri-user-search-line"></i></span>
        </div>
        <div class="search-candidates-hero-content">
            <h1>Search <span>Candidates</span></h1>
            <p>Discover top talent for your organization. Use the search and filters below to find the best candidates.</p>
        </div>
    </section>

    <!-- Search Filters Section -->
    <section class="search-filters-section">
        <div class="container">
            <form class="filters-card" method="get" action="">
                <h3><i class="ri-filter-3-line"></i> Search Filters</h3>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="jobTitle">Job Title/Keywords</label>
                        <input type="text" id="jobTitle" name="jobTitle" value="<?= htmlspecialchars($filters['jobTitle']) ?>" placeholder="e.g. Frontend Developer, React, UI/UX">
                    </div>
                    <div class="filter-group">
                        <label for="location">Location</label>
                        <select id="location" name="location">
                            <option value="">Any Location</option>
                            <option value="dhaka" <?= $filters['location']==='dhaka'?'selected':'' ?>>Dhaka</option>
                            <option value="chittagong" <?= $filters['location']==='chittagong'?'selected':'' ?>>Chittagong</option>
                            <option value="sylhet" <?= $filters['location']==='sylhet'?'selected':'' ?>>Sylhet</option>
                            <option value="remote" <?= $filters['location']==='remote'?'selected':'' ?>>Remote</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="experience">Experience Level</label>
                        <select id="experience" name="experience">
                            <option value="">Any Experience</option>
                            <option value="entry" <?= $filters['experience']==='entry'?'selected':'' ?>>Entry Level (0-2 years)</option>
                            <option value="mid" <?= $filters['experience']==='mid'?'selected':'' ?>>Mid Level (3-5 years)</option>
                            <option value="senior" <?= $filters['experience']==='senior'?'selected':'' ?>>Senior Level (5+ years)</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="skills">Skills</label>
                        <input type="text" id="skills" name="skills" value="<?= htmlspecialchars($filters['skills']) ?>" placeholder="e.g. JavaScript, Python, React">
                    </div>
                    <div class="filter-group">
                        <label for="availability">Availability</label>
                        <select id="availability" name="availability">
                            <option value="">Any Availability</option>
                            <option value="immediate" <?= $filters['availability']==='immediate'?'selected':'' ?>>Immediate</option>
                            <option value="2weeks" <?= $filters['availability']==='2weeks'?'selected':'' ?>>2 Weeks Notice</option>
                            <option value="1month" <?= $filters['availability']==='1month'?'selected':'' ?>>1 Month Notice</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="salary">Expected Salary</label>
                        <select id="salary" name="salary">
                            <option value="">Any Salary</option>
                            <option value="20k-40k" <?= $filters['salary']==='20k-40k'?'selected':'' ?>>20K - 40K BDT</option>
                            <option value="40k-60k" <?= $filters['salary']==='40k-60k'?'selected':'' ?>>40K - 60K BDT</option>
                            <option value="60k-80k" <?= $filters['salary']==='60k-80k'?'selected':'' ?>>60K - 80K BDT</option>
                            <option value="80k+" <?= $filters['salary']==='80k+'?'selected':'' ?>>80K+ BDT</option>
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="search-btn" type="submit">
                        <i class="ri-search-line"></i>
                        Search Candidates
                    </button>
                    <a href="search-candidates.php" class="clear-btn">Clear Filters</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Candidate Results Section -->
    <section class="candidates-results-section">
        <div class="container">
            <div class="results-header">
                <h2>Top Candidates</h2>
                <div class="results-count">
                    <span>Showing <strong><?= count($candidates) ?></strong> of <strong><?= $totalCandidates ?></strong> candidates</span>
                </div>
                <div class="sort-options">
                    <label for="sortBy">Sort by:</label>
                    <select id="sortBy" disabled>
                        <option value="relevance">Relevance</option>
                        <option value="experience">Experience</option>
                        <option value="skills">Skills Match</option>
                        <option value="recent">Recently Active</option>
                    </select>
                </div>
            </div>

            <div class="candidates-grid">
                <?php foreach ($candidates as $cand): ?>
                <div class="candidate-card">
                    <div class="candidate-header">
                        <div class="candidate-avatar">
                            <?php if (!empty($cand['photo'])): ?>
                                <img src="<?= htmlspecialchars($cand['photo']) ?>" alt="<?= htmlspecialchars($cand['name']) ?>">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($cand['name']) ?>&background=ded6f7&color=512da8" alt="<?= htmlspecialchars($cand['name']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="candidate-info">
                            <h3><?= htmlspecialchars($cand['name']) ?></h3>
                            <p class="candidate-title"><?= isset($cand['title']) ? htmlspecialchars($cand['title']) : 'N/A' ?></p>
                            <p class="candidate-location"><i class="ri-map-pin-line"></i> <?= isset($cand['location']) ? htmlspecialchars($cand['location']) : 'N/A' ?></p>
                        </div>
                    </div>
                    <div class="candidate-skills">
                        <?php if (!empty($cand['skills'])): ?>
                            <?php foreach (explode(',', $cand['skills']) as $skill): ?>
                                <span class="skill-tag"><?= htmlspecialchars(trim($skill)) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="skill-tag">N/A</span>
                        <?php endif; ?>
                    </div>
                    <div class="candidate-details">
                        <?php if (isset($cand['bio'])): ?><p class="bio"><i class="ri-user-3-line"></i> <?= htmlspecialchars($cand['bio']) ?></p><?php endif; ?>
                    </div>
                    <div class="candidate-actions">
                        <a href="candidate-profile.php?id=<?= $cand['id'] ?>" class="view-profile-btn">View Profile</a>
                        <a class="contact-btn" href="mailto:<?= htmlspecialchars($cand['email']) ?>"><i class="ri-message-3-line"></i> Contact</a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($candidates)): ?>
                    <div style="padding:2rem;color:#888;">No candidates found matching your criteria.</div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <a class="pagination-btn" href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page-1)])) ?>" <?= $page <= 1 ? 'style="pointer-events:none;opacity:0.5;"' : '' ?>><i class="ri-arrow-left-s-line"></i> Previous</a>
                <div class="page-numbers">
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <a class="page-number<?= $p == $page ? ' active' : '' ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"> <?= $p ?> </a>
                    <?php endfor; ?>
                </div>
                <a class="pagination-btn" href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page+1)])) ?>" <?= $page >= $totalPages ? 'style="pointer-events:none;opacity:0.5;"' : '' ?>>Next <i class="ri-arrow-right-s-line"></i></a>
            </div>
        </div>
    </section>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html> 