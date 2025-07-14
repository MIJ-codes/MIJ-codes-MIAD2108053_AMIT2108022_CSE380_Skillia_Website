<?php
require_once 'includes/db.php';

try {
    // Create test employer user
    $stmt = $pdo->prepare('INSERT IGNORE INTO users (id, name, email, password, user_type) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([100, 'Test Employer', 'employer@test.com', password_hash('password123', PASSWORD_DEFAULT), 'employer']);
    
    // Create test job seeker user
    $stmt = $pdo->prepare('INSERT IGNORE INTO users (id, name, email, password, user_type) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([101, 'Test Job Seeker', 'jobseeker@test.com', password_hash('password123', PASSWORD_DEFAULT), 'job_seeker']);
    
    // Create test employer profile
    $stmt = $pdo->prepare('INSERT IGNORE INTO employers (id, user_id, company_name, company_description, phone, position) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([50, 100, 'Test Company', 'A test company for testing purposes', '123-456-7890', 'HR Manager']);
    
    // Create test job seeker profile
    $stmt = $pdo->prepare('INSERT IGNORE INTO job_seekers (id, user_id, skills, experience, education) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([50, 101, 'PHP, JavaScript, MySQL', '2 years', 'Bachelor Degree']);
    
    // Create test job
    $stmt = $pdo->prepare('INSERT IGNORE INTO jobs (id, employer_id, title, description, location, salary, company_name, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
    $stmt->execute([200, 50, 'Test Developer Position', 'A test job for testing purposes', 'Remote', '$50,000 - $60,000', 'Test Company']);
    
    // Create test applications
    $stmt = $pdo->prepare('INSERT IGNORE INTO applications (id, job_id, seeker_id, status, applied_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([300, 200, 50, 'pending']); // Application without interview
    
    $stmt = $pdo->prepare('INSERT IGNORE INTO applications (id, job_id, seeker_id, status, applied_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([301, 200, 50, 'accepted']); // Application with interview
    
    // Create test interview for application 301
    $stmt = $pdo->prepare('INSERT IGNORE INTO interviews (id, application_id, employer_id, job_seeker_id, job_id, interview_date, interview_time, location_medium, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
    $stmt->execute([400, 301, 50, 50, 200, '2024-01-15', '10:00:00', 'Zoom Meeting', 'scheduled']);
    
    echo "Test data created successfully!\n";
    echo "Employer login: employer@test.com / password123\n";
    echo "Job Seeker login: jobseeker@test.com / password123\n";
    echo "Application 300: No interview (should reject immediately)\n";
    echo "Application 301: Has scheduled interview (should show modal)\n";
    
} catch (Exception $e) {
    echo "Error creating test data: " . $e->getMessage() . "\n";
}
?>
