<!DOCTYPE html>
<html>
<head>
    <title>Database Test</title>
</head>
<body>
    <h1>Database Connection Test</h1>
    <?php
    try {
        require_once 'includes/db.php';
        echo "<p style='color: green;'>✓ Database connection successful!</p>";
        
        // Check if tables exist
        $tables = ['users', 'employers', 'job_seekers', 'jobs', 'applications', 'interviews', 'notifications'];
        echo "<h2>Table Check:</h2>";
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            } else {
                echo "<p style='color: red;'>✗ Table '$table' does NOT exist</p>";
            }
        }
        
        // Create test data
        echo "<h2>Creating Test Data:</h2>";
        
        // Delete existing test data first
        $pdo->exec("DELETE FROM interviews WHERE application_id IN (SELECT id FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE employer_id IN (SELECT id FROM employers WHERE user_id IN (SELECT id FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com')))))");
        $pdo->exec("DELETE FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE employer_id IN (SELECT id FROM employers WHERE user_id IN (SELECT id FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com'))))");
        $pdo->exec("DELETE FROM jobs WHERE employer_id IN (SELECT id FROM employers WHERE user_id IN (SELECT id FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com')))");
        $pdo->exec("DELETE FROM employers WHERE user_id IN (SELECT id FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com'))");
        $pdo->exec("DELETE FROM job_seekers WHERE user_id IN (SELECT id FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com'))");
        $pdo->exec("DELETE FROM users WHERE email IN ('employer@test.com', 'jobseeker@test.com')");
        
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        
        // Create test employer user
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)');
        $result = $stmt->execute(['Test Employer', 'employer@test.com', $hashedPassword, 'employer']);
        
        if ($result) {
            $userId = $pdo->lastInsertId();
            echo "<p style='color: green;'>✓ Test employer user created with ID: $userId</p>";
            
            // Create employer profile
            $stmt = $pdo->prepare('INSERT INTO employers (user_id, company_name, company_description, phone, position) VALUES (?, ?, ?, ?, ?)');
            $result = $stmt->execute([$userId, 'Test Company', 'A test company for testing purposes', '123-456-7890', 'HR Manager']);
            
            if ($result) {
                $employerId = $pdo->lastInsertId();
                echo "<p style='color: green;'>✓ Employer profile created with ID: $employerId</p>";
                
                // Create a test job
                $stmt = $pdo->prepare('INSERT INTO jobs (employer_id, title, description, location, salary, company_name, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
                $result = $stmt->execute([$employerId, 'Test Developer Position', 'A test job for testing purposes', 'Remote', '$50,000 - $60,000', 'Test Company']);
                
                if ($result) {
                    $jobId = $pdo->lastInsertId();
                    echo "<p style='color: green;'>✓ Test job created with ID: $jobId</p>";
                    
                    // Create test job seeker
                    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)');
                    $result = $stmt->execute(['Test Job Seeker', 'jobseeker@test.com', $hashedPassword, 'job_seeker']);
                    
                    if ($result) {
                        $jobSeekerUserId = $pdo->lastInsertId();
                        echo "<p style='color: green;'>✓ Job seeker user created with ID: $jobSeekerUserId</p>";
                        
                        // Create job seeker profile
                        $stmt = $pdo->prepare('INSERT INTO job_seekers (user_id, skills, experience, education) VALUES (?, ?, ?, ?)');
                        $result = $stmt->execute([$jobSeekerUserId, 'PHP, JavaScript, MySQL', '2 years', 'Bachelor Degree']);
                        
                        if ($result) {
                            $jobSeekerId = $pdo->lastInsertId();
                            echo "<p style='color: green;'>✓ Job seeker profile created with ID: $jobSeekerId</p>";
                            
                            // Create test applications
                            $stmt = $pdo->prepare('INSERT INTO applications (job_id, seeker_id, status, applied_at) VALUES (?, ?, ?, NOW())');
                            
                            // Application without interview
                            $result = $stmt->execute([$jobId, $jobSeekerId, 'pending']);
                            if ($result) {
                                $app1Id = $pdo->lastInsertId();
                                echo "<p style='color: green;'>✓ Application 1 (no interview) created with ID: $app1Id</p>";
                            }
                            
                            // Application with interview
                            $result = $stmt->execute([$jobId, $jobSeekerId, 'accepted']);
                            if ($result) {
                                $app2Id = $pdo->lastInsertId();
                                echo "<p style='color: green;'>✓ Application 2 (with interview) created with ID: $app2Id</p>";
                                
                                // Create interview for application 2
                                $stmt = $pdo->prepare('INSERT INTO interviews (application_id, employer_id, job_seeker_id, job_id, interview_date, interview_time, location_medium, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
                                $result = $stmt->execute([$app2Id, $employerId, $jobSeekerId, $jobId, '2024-01-15', '10:00:00', 'Zoom Meeting', 'scheduled']);
                                
                                if ($result) {
                                    $interviewId = $pdo->lastInsertId();
                                    echo "<p style='color: green;'>✓ Interview created with ID: $interviewId</p>";
                                }
                            }
                        }
                    }
                }
            }
        }
        
        echo "<h2 style='color: green;'>✓ Test data creation completed!</h2>";
        echo "<p><strong>Login credentials:</strong> employer@test.com / password123</p>";
        echo "<p><a href='pages/login.php'>Go to Login Page</a></p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p style='color: red;'>Stack trace: " . htmlspecialchars($e->getTraceAsString()) . "</p>";
    }
    ?>
</body>
</html>
