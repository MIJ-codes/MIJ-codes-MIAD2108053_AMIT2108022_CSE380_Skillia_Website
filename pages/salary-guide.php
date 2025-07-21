<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../includes/db.php';

// Salary Calculator Logic
$salary_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job-title'])) {
    $title = trim($_POST['job-title']);
    $location = trim($_POST['location']);
    $experience = trim($_POST['experience']);
    $jobType = trim($_POST['jobType']);
    $params = [];
    $where = [];
    if ($title !== '') {
        $where[] = '(title LIKE :title)';
        $params[':title'] = "%$title%";
    }
    if ($location !== '') {
        $where[] = '(location = :location)';
        $params[':location'] = $location;
    }
    if ($experience !== '') {
        $where[] = '(experience_level = :experience)';
        $params[':experience'] = $experience;
    }
    if ($jobType !== '') {
        $where[] = '(job_type = :jobType)';
        $params[':jobType'] = $jobType;
    }
    $sql = "SELECT salary FROM jobs";
    if ($where) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $salaries = [];
    while ($row = $stmt->fetch()) {
        // Parse salary (handle ranges and currency)
        $salary_str = $row['salary'];
        if (preg_match('/([0-9,]+)/', $salary_str, $matches)) {
            $salary_val = (int)str_replace(',', '', $matches[1]);
            $salaries[] = $salary_val;
        }
        if (preg_match('/([0-9,]+)\s*-\s*([0-9,]+)/', $salary_str, $matches)) {
            $salaries[] = (int)str_replace(',', '', $matches[1]);
            $salaries[] = (int)str_replace(',', '', $matches[2]);
        }
    }
    if ($salaries) {
        $min_salary = min($salaries);
        $max_salary = max($salaries);
        $salary_result = [
            'min' => number_format($min_salary),
            'max' => number_format($max_salary),
            'count' => count($salaries)
        ];
    } else {
        $salary_result = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skillia - Salary Guide</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/salary-guide.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
<?php include '../includes/header.php'; ?>

<!-- Hero Section -->
<div class="sg-hero-section">
  <div class="sg-hero-bg"></div>
  <div class="sg-hero-content">
    <h1 class="sg-hero-title" style="color:#fff;text-shadow:1px 1px 0 #ffd600,-1px -1px 0 #7c4dff;">Salary Guide</h1>
    <p class="sg-hero-subtitle" style="color:#7c4dff;">Plan your next move with up-to-date salary data and insights</p>
  </div>
  <div class="animated-coins">
    <span style="background:rgba(255,214,0,0.18);"></span>
    <span style="background:rgba(255,112,67,0.18);"></span>
    <span style="background:rgba(124,77,255,0.18);"></span>
    <span style="background:rgba(255,214,0,0.18);"></span>
    <span style="background:rgba(255,112,67,0.18);"></span>
  </div>
</div>

<!-- Calculator Section -->
<div class="sg-calculator-section">
  <div class="sg-calculator-container">
    <h2 class="sg-calculator-title" style="color:#ff7043;">Salary Calculator</h2>
    <form class="sg-calculator-form" method="post" action="">
      <div class="sg-form-row">
        <div class="sg-form-group">
          <label for="job-title" style="color:#7c4dff;">Job Title</label>
          <input type="text" id="job-title" name="job-title" placeholder="e.g., Software Engineer, Marketing Manager" value="<?php echo isset($_POST['job-title']) ? htmlspecialchars($_POST['job-title']) : ''; ?>">
        </div>
        <div class="sg-form-group">
          <label for="location" style="color:#7c4dff;">Location</label>
          <div class="custom-category-dropdown location-dropdown" tabindex="0">
            <span class="selected-category">
              <?php
              $loc = isset($_POST['location']) ? $_POST['location'] : '';
              echo $loc ? htmlspecialchars($loc) : 'Select Location';
              ?>
            </span>
            <ul class="category-options" style="display:none;">
              <li data-value="">Select Location</li>
              <li data-value="Remote" <?php if($loc === 'Remote') echo 'class="selected"'; ?>>Remote</li>
              <li data-value="New York" <?php if($loc === 'New York') echo 'class="selected"'; ?>>New York</li>
              <li data-value="San Francisco" <?php if($loc === 'San Francisco') echo 'class="selected"'; ?>>San Francisco</li>
              <li data-value="London" <?php if($loc === 'London') echo 'class="selected"'; ?>>London</li>
              <li data-value="Berlin" <?php if($loc === 'Berlin') echo 'class="selected"'; ?>>Berlin</li>
              <li data-value="Dhaka, Bangladesh" <?php if($loc === 'Dhaka, Bangladesh') echo 'class="selected"'; ?>>Dhaka, Bangladesh</li>
            </ul>
            <input type="hidden" name="location" value="<?php echo htmlspecialchars($loc); ?>">
          </div>
        </div>
      </div>
      <div class="sg-form-row">
        <div class="sg-form-group">
          <label for="jobType" style="color:#7c4dff;">Job Type</label>
          <div class="custom-category-dropdown jobtype-dropdown" tabindex="0">
            <span class="selected-category">
              <?php
              $jobType = isset($_POST['jobType']) ? $_POST['jobType'] : '';
              echo $jobType ? htmlspecialchars($jobType) : 'Select Job Type';
              ?>
            </span>
            <ul class="category-options" style="display:none;">
              <li data-value="">Select Job Type</li>
              <li data-value="Full-time" <?php if($jobType === 'Full-time') echo 'class="selected"'; ?>>Full Time</li>
              <li data-value="Part-time" <?php if($jobType === 'Part-time') echo 'class="selected"'; ?>>Part Time</li>
              <li data-value="Contract" <?php if($jobType === 'Contract') echo 'class="selected"'; ?>>Contract</li>
              <li data-value="Internship" <?php if($jobType === 'Internship') echo 'class="selected"'; ?>>Internship</li>
            </ul>
            <input type="hidden" name="jobType" value="<?php echo htmlspecialchars($jobType); ?>">
          </div>
        </div>
        <div class="sg-form-group">
          <label for="experience" style="color:#7c4dff;">Years of Experience</label>
          <div class="custom-category-dropdown experience-dropdown" tabindex="0">
            <span class="selected-category">
              <?php
              $exp = isset($_POST['experience']) ? $_POST['experience'] : '';
              echo $exp ? htmlspecialchars($exp) : 'Select Experience';
              ?>
            </span>
            <ul class="category-options" style="display:none;">
              <li data-value="">Select Experience</li>
              <li data-value="Entry Level" <?php if($exp === 'Entry Level') echo 'class="selected"'; ?>>Entry Level (0-1 years)</li>
              <li data-value="Mid Level" <?php if($exp === 'Mid Level') echo 'class="selected"'; ?>>Mid Level (2-4 years)</li>
              <li data-value="Senior Level" <?php if($exp === 'Senior Level') echo 'class="selected"'; ?>>Senior Level (5-10 years)</li>
              <li data-value="Manager" <?php if($exp === 'Manager') echo 'class="selected"'; ?>>Manager (10+ years)</li>
            </ul>
            <input type="hidden" name="experience" value="<?php echo htmlspecialchars($exp); ?>">
          </div>
        </div>
      </div>
      <button type="submit" class="sg-calculate-btn" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);color:#fff;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="4" stroke="#ff7043" stroke-width="2"/><path d="M8 8h8M8 12h8M8 16h8" stroke="#7c4dff" stroke-width="2" stroke-linecap="round"/></svg>
        Calculate Salary
      </button>
    </form>
    <div class="sg-result" style="<?php echo $salary_result !== null ? '' : 'display:none;'; ?>">
      <?php if ($salary_result && is_array($salary_result)): ?>
      <h3 style="color:#ff7043;">Estimated Salary Range</h3>
        <div class="salary-amount" style="color:#ffd600;">
          $<?php echo $salary_result['min']; ?> - $<?php echo $salary_result['max']; ?>
        </div>
        <div class="salary-range" style="color:#7c4dff;">
          Based on <?php echo $salary_result['count']; ?> matching job(s) in our database
        </div>
      <?php elseif ($salary_result === false): ?>
        <h3 style="color:#ff7043;">No matching jobs found</h3>
        <div class="salary-range" style="color:#7c4dff;">Try different criteria for more results.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Market Section -->
<div class="sg-market-section">
  <div class="sg-market-container">
    <h2 class="sg-market-title" style="color:#ff7043;">Market Salary Data</h2>
    <div class="sg-market-grid">
      <?php
      // Query for top job titles by average salary with normalized grouping
      $market_sql = "
        SELECT 
          MIN(title) as display_title,
          LOWER(TRIM(REPLACE(REPLACE(title, '  ', ' '), '  ', ' '))) AS normalized_title,
          AVG(CAST(REPLACE(REPLACE(REPLACE(salary, '$', ''), ',', ''), ' BDT', '') AS UNSIGNED)) as avg_salary,
          COUNT(*) as job_count
        FROM jobs 
        WHERE salary IS NOT NULL AND salary != ''
        GROUP BY normalized_title
        HAVING avg_salary > 0 AND job_count >= 1
        ORDER BY avg_salary DESC 
        LIMIT 6
      ";
      $market_stmt = $pdo->query($market_sql);
      $market_jobs = $market_stmt->fetchAll();
      
      if ($market_jobs) {
        foreach ($market_jobs as $job) {
          $title = htmlspecialchars($job['display_title']);
          $avg_salary = number_format($job['avg_salary']);
          $job_count = $job['job_count'];

          
          // Enhanced description system based on job categories and common patterns
          $descriptions = [
            // Programming & Tech
            'Software Engineer' => 'High demand for skilled developers with expertise in modern technologies and frameworks.',
            'Software Developer' => 'Core development role with strong demand across all industries and company sizes.',
            'Frontend Developer' => 'Critical for creating responsive and user-friendly web interfaces and applications.',
            'Backend Developer' => 'Essential role for building robust server-side applications and database systems.',
            'Full Stack Developer' => 'Versatile role combining frontend and backend development skills for complete solutions.',
            'Web Developer' => 'Specialized in creating and maintaining websites with modern web technologies.',
            'Mobile Developer' => 'Growing demand for iOS and Android app development expertise.',
            'DevOps Engineer' => 'Bridge between development and operations, ensuring smooth deployment and maintenance.',
            'Data Engineer' => 'Building data pipelines and infrastructure for analytics and machine learning.',
            'AI Engineer' => 'Cutting-edge field with high demand for artificial intelligence and machine learning expertise.',
            'Machine Learning Engineer' => 'Developing AI models and algorithms for predictive analytics and automation.',
            
            // Design & Creative
            'UX Designer' => 'User experience design is critical for digital products and customer satisfaction.',
            'UI Designer' => 'Creating visually appealing and intuitive user interfaces for web and mobile applications.',
            'Graphic Designer' => 'Visual communication and branding expertise across digital and print media.',
            'Product Designer' => 'Strategic design role combining user research, prototyping, and visual design.',
            
            // Marketing & Sales
            'Marketing Manager' => 'Digital marketing skills and data-driven decision making are highly valued in this role.',
            'Digital Marketing Specialist' => 'Expertise in online marketing channels including SEO, social media, and PPC.',
            'Content Marketing Manager' => 'Creating and managing content strategies to drive engagement and conversions.',
            'Sales Representative' => 'Traditional sales roles are evolving with technology and automation changes.',
            'Sales Manager' => 'Leading sales teams and developing strategies to meet revenue targets.',
            
            // Data & Analytics
            'Data Analyst' => 'Rapidly growing field with increasing demand for data-driven insights across industries.',
            'Data Scientist' => 'Advanced analytics and machine learning to solve complex business problems.',
            'Business Analyst' => 'Bridge between business needs and technical solutions for process improvement.',
            
            // Management & Leadership
            'Product Manager' => 'Strategic role combining technical knowledge with business acumen and leadership skills.',
            'Project Manager' => 'Coordinating teams and resources to deliver projects on time and within budget.',
            'Operations Manager' => 'Overseeing daily operations and ensuring efficiency across business processes.',
            
            // Healthcare & Science
            'Nurse' => 'Essential healthcare role with strong job security and meaningful patient care.',
            'Pharmacist' => 'Specialized healthcare role with expertise in medication management and patient safety.',
            'Research Scientist' => 'Conducting research and development in various scientific and technical fields.',
            
            // Finance & Accounting
            'Accountant' => 'Financial record keeping and reporting for businesses and organizations.',
            'Financial Analyst' => 'Analyzing financial data to support business decisions and investment strategies.',
            'Auditor' => 'Ensuring financial compliance and identifying areas for improvement in business processes.',
            
            // Education & Training
            'Teacher' => 'Educating students with meaningful work and strong job security.',
            'Trainer' => 'Developing and delivering training programs for employee skill development.',
            'Instructional Designer' => 'Creating effective learning experiences and educational content.',
            
            // Customer Service & Support
            'Customer Service Representative' => 'Providing support and assistance to customers across various channels.',
            'Technical Support Specialist' => 'Resolving technical issues and providing guidance to users.',
            'Help Desk Specialist' => 'First-line technical support for IT systems and software applications.'
          ];
          
          // Try to find exact match first, then look for partial matches
          $description = $descriptions[$title] ?? null;
          
          // If no exact match, try to find partial matches based on common keywords
          if (!$description) {
            $title_lower = strtolower($title);
            if (strpos($title_lower, 'developer') !== false) {
              $description = 'Software development role with strong demand for technical skills and problem-solving abilities.';
            } elseif (strpos($title_lower, 'engineer') !== false) {
              $description = 'Engineering role requiring technical expertise and analytical problem-solving skills.';
            } elseif (strpos($title_lower, 'manager') !== false) {
              $description = 'Leadership role combining technical knowledge with team management and strategic planning.';
            } elseif (strpos($title_lower, 'analyst') !== false) {
              $description = 'Data analysis role focused on extracting insights and supporting business decisions.';
            } elseif (strpos($title_lower, 'designer') !== false) {
              $description = 'Creative role focused on user experience, visual design, or product design.';
            } elseif (strpos($title_lower, 'scientist') !== false) {
              $description = 'Research and analysis role requiring advanced technical knowledge and analytical skills.';
            } elseif (strpos($title_lower, 'specialist') !== false) {
              $description = 'Specialized role with deep expertise in a specific area or technology.';
            } elseif (strpos($title_lower, 'coordinator') !== false) {
              $description = 'Coordination role managing projects, events, or organizational processes.';
            } elseif (strpos($title_lower, 'assistant') !== false) {
              $description = 'Support role providing administrative or technical assistance to teams or managers.';
            } elseif (strpos($title_lower, 'consultant') !== false) {
              $description = 'Advisory role providing expert guidance and solutions to clients or organizations.';
            } elseif (strpos($title_lower, 'director') !== false) {
              $description = 'Senior leadership role overseeing departments, strategies, and organizational direction.';
            } elseif (strpos($title_lower, 'executive') !== false) {
              $description = 'High-level leadership role with strategic decision-making and organizational oversight.';
            } elseif (strpos($title_lower, 'officer') !== false) {
              $description = 'Professional role with specialized responsibilities and organizational leadership.';
            } elseif (strpos($title_lower, 'lead') !== false) {
              $description = 'Team leadership role combining technical expertise with people management skills.';
            } elseif (strpos($title_lower, 'architect') !== false) {
              $description = 'Senior technical role designing complex systems and providing technical leadership.';
            } elseif (strpos($title_lower, 'administrator') !== false) {
              $description = 'System administration role managing technical infrastructure and user support.';
            } elseif (strpos($title_lower, 'trainer') !== false) {
              $description = 'Training and development role focused on skill-building and knowledge transfer.';
            } elseif (strpos($title_lower, 'instructor') !== false) {
              $description = 'Educational role teaching skills and knowledge to students or employees.';
            } elseif (strpos($title_lower, 'writer') !== false) {
              $description = 'Content creation role producing written materials for various media and platforms.';
            } elseif (strpos($title_lower, 'editor') !== false) {
              $description = 'Content editing role ensuring quality and consistency in written materials.';
            } elseif (strpos($title_lower, 'creator') !== false) {
              $description = 'Content creation role developing engaging materials for digital and traditional media.';
            } elseif (strpos($title_lower, 'marketing') !== false) {
              $description = 'Marketing role focused on promoting products, services, or brands to target audiences.';
            } elseif (strpos($title_lower, 'sales') !== false) {
              $description = 'Sales role focused on generating revenue through customer relationships and product knowledge.';
            } elseif (strpos($title_lower, 'support') !== false) {
              $description = 'Customer support role providing assistance and resolving issues for clients or users.';
            } elseif (strpos($title_lower, 'representative') !== false) {
              $description = 'Client-facing role representing the organization and providing customer service.';
            } else {
              $description = 'Professional role with competitive salary and growth opportunities in the current market.';
            }
          }
          
          echo '<div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">';
          echo '<h3 style="color:#ff7043;">' . $title . '</h3>';
          echo '<div class="salary-data">';
          echo '<span class="avg-salary" style="color:#ffd600;">$' . $avg_salary . '</span>';
          echo '</div>';
          echo '<p>' . $description . '</p>';
          echo '<small style="color:#666;font-size:12px;">Based on ' . $job_count . ' job postings</small>';
          echo '</div>';
        }
      } else {
        // Fallback to static data if no database results
        $fallback_jobs = [
          ['title' => 'Software Engineer', 'salary' => '95,000', 'growth' => '8.5', 'desc' => 'High demand for skilled developers with expertise in modern technologies and frameworks.'],
          ['title' => 'Marketing Manager', 'salary' => '78,000', 'growth' => '6.2', 'desc' => 'Digital marketing skills and data-driven decision making are highly valued in this role.'],
          ['title' => 'Data Analyst', 'salary' => '72,000', 'growth' => '12.3', 'desc' => 'Rapidly growing field with increasing demand for data-driven insights across industries.'],
          ['title' => 'Product Manager', 'salary' => '105,000', 'growth' => '9.1', 'desc' => 'Strategic role combining technical knowledge with business acumen and leadership skills.'],
          ['title' => 'UX Designer', 'salary' => '82,000', 'growth' => '7.8', 'desc' => 'User experience design is critical for digital products and customer satisfaction.'],
          ['title' => 'Sales Representative', 'salary' => '65,000', 'growth' => '-2.1', 'desc' => 'Traditional sales roles are evolving with technology and automation changes.']
        ];
        
        foreach ($fallback_jobs as $job) {
          echo '<div class="sg-market-card" style="border-color:rgba(255,214,0,0.08);">';
          echo '<h3 style="color:#ff7043;">' . $job['title'] . '</h3>';
          echo '<div class="salary-data">';
          echo '<span class="avg-salary" style="color:#ffd600;">$' . $job['salary'] . '</span>';
          echo '</div>';
          echo '<p>' . $job['desc'] . '</p>';
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>
</div>


<div class="sg-industries-section">
  <div class="sg-industries-container">
    <h2 class="sg-industries-title" style="color:#ff7043;">Salary by Category</h2>
    <div class="sg-industries-grid">
      <?php
      // Get top 6 categories with highest job counts and salary data
      $category_sql = "
        SELECT 
          c.id,
          c.name as category_name,
          c.description as category_description,
          c.icon as category_icon,
          MIN(CAST(REPLACE(REPLACE(REPLACE(j.salary, '$', ''), ',', ''), ' BDT', '') AS UNSIGNED)) as min_salary,
          MAX(CAST(REPLACE(REPLACE(REPLACE(j.salary, '$', ''), ',', ''), ' BDT', '') AS UNSIGNED)) as max_salary,
          COUNT(j.id) as total_jobs,
          SUM(CASE WHEN j.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as jobs_last_7_days
        FROM categories c
        LEFT JOIN jobs j ON c.id = j.category_id
        WHERE j.salary IS NOT NULL AND j.salary != ''
        GROUP BY c.id, c.name, c.description, c.icon
        HAVING total_jobs > 0
        ORDER BY total_jobs DESC, max_salary DESC
        LIMIT 6
      ";
      
      $category_stmt = $pdo->query($category_sql);
      $category_data = $category_stmt->fetchAll();
      
      if ($category_data) {
        foreach ($category_data as $category) {
          $category_name = htmlspecialchars($category['category_name']);
          $min_salary = number_format($category['min_salary']);
          $max_salary = number_format($category['max_salary']);
          $total_jobs = $category['total_jobs'];
          $jobs_last_7_days = $category['jobs_last_7_days'];
          
          // Calculate percentage increase in last 7 days
          $previous_jobs = $total_jobs - $jobs_last_7_days;
          $increase_percentage = 0;
          if ($previous_jobs > 0) {
            $increase_percentage = round(($jobs_last_7_days / $previous_jobs) * 100);
          } elseif ($jobs_last_7_days > 0) {
            $increase_percentage = 100; // New category with jobs in last 7 days
          }
          
          $increase_color = $increase_percentage > 0 ? '#ffd600' : '#ff7043';
          $increase_bg = $increase_percentage > 0 ? 'rgba(255,214,0,0.10)' : 'rgba(255,112,67,0.10)';
          
          echo '<div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">';
          echo '<div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">';
          echo '<i class="' . htmlspecialchars($category['category_icon']) . '" style="color:#fff;font-size:24px;"></i>';
          echo '</div>';
          echo '<h3 style="color:#ff7043;">' . $category_name . '</h3>';
          echo '<div class="salary-range" style="color:#ffd600;">$' . $min_salary . ' - $' . $max_salary . '</div>';
          echo '<div class="job-stats" style="display:flex;align-items:center;margin:8px 0;">';
          echo '<span class="total-jobs" style="color:#7c4dff;font-size:14px;">' . $total_jobs . ' jobs</span>';
          if ($jobs_last_7_days > 0) {
            echo '<span class="increase-rate" style="background:' . $increase_bg . ';color:' . $increase_color . ';padding:4px 8px;border-radius:12px;font-size:12px;margin-left:8px;">+' . $increase_percentage . '%</span>';
          }
          echo '</div>';
          echo '<p style="color:#666;font-size:14px;">' . htmlspecialchars($category['category_description']) . '</p>';
          echo '</div>';
        }
      } else {
        // Fallback to static data if no database results
        $fallback_categories = [
          ['name' => 'Programming & Tech', 'min' => '60,000', 'max' => '120,000', 'jobs' => 15, 'increase' => 25, 'desc' => 'Full-stack development, mobile apps, web development, and software engineering roles.'],
          ['name' => 'Graphics & Design', 'min' => '45,000', 'max' => '95,000', 'jobs' => 12, 'increase' => 18, 'desc' => 'Visual design, branding, UI/UX design, and creative roles.'],
          ['name' => 'Digital Marketing', 'min' => '50,000', 'max' => '100,000', 'jobs' => 10, 'increase' => 30, 'desc' => 'SEO, SEM, content marketing, and social media management.'],
          ['name' => 'AI Services', 'min' => '70,000', 'max' => '130,000', 'jobs' => 8, 'increase' => 45, 'desc' => 'Artificial intelligence, machine learning, and automation services.'],
          ['name' => 'Business', 'min' => '55,000', 'max' => '110,000', 'jobs' => 9, 'increase' => 20, 'desc' => 'Business analysis, project management, and operations roles.'],
          ['name' => 'Finance & Accounting', 'min' => '60,000', 'max' => '115,000', 'jobs' => 7, 'increase' => 15, 'desc' => 'Financial planning, bookkeeping, and accounting services.']
        ];
        
        foreach ($fallback_categories as $cat) {
          echo '<div class="sg-industry-card" style="border-color:rgba(255,214,0,0.08);">';
          echo '<div class="sg-industry-icon" style="background:linear-gradient(135deg,#ff7043 0%,#ffd600 70%,#7c4dff 100%);">';
          echo '<i class="ri-briefcase-4-line" style="color:#fff;font-size:24px;"></i>';
          echo '</div>';
          echo '<h3 style="color:#ff7043;">' . $cat['name'] . '</h3>';
          echo '<div class="salary-range" style="color:#ffd600;">$' . $cat['min'] . ' - $' . $cat['max'] . '</div>';
          echo '<div class="job-stats" style="display:flex;align-items:center;margin:8px 0;">';
          echo '<span class="total-jobs" style="color:#7c4dff;font-size:14px;">' . $cat['jobs'] . ' jobs</span>';
          echo '<span class="increase-rate" style="background:rgba(255,214,0,0.10);color:#ffd600;padding:4px 8px;border-radius:12px;font-size:12px;margin-left:8px;">+' . $cat['increase'] . '%</span>';
          echo '</div>';
          echo '<p style="color:#666;font-size:14px;">' . $cat['desc'] . '</p>';
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>
</div>

<!-- Trends Section -->
<div class="sg-trends-section">
  <div class="sg-trends-container">
    <h2 class="sg-trends-title" style="color:#ff7043;">Salary Trends & Insights</h2>
    <div class="sg-trends-list">
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Remote Work Impact</h4>
          <p>Remote positions often offer competitive salaries while reducing living costs, making them highly attractive to job seekers.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Skills-Based Pay</h4>
          <p>Companies are increasingly valuing specific skills and certifications over traditional education requirements.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Geographic Variations</h4>
          <p>Salary ranges vary significantly by location, with tech hubs and major cities offering higher compensation.</p>
        </div>
      </div>
      <div class="sg-trend-item">
        <div class="sg-trend-icon" style="background:rgba(255,112,67,0.10);color:#ff7043;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#ffd600" stroke-width="2"/><path d="M12 8v4l3 3" stroke="#7c4dff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="sg-trend-content">
          <h4 style="color:#7c4dff;">Experience Premium</h4>
          <p>Experienced professionals can command 20-40% higher salaries than entry-level positions in the same field.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/salary-guide.js"></script>
<?php include '../includes/footer.php'; ?> 
</body>
</html> 