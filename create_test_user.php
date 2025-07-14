<?php
require_once 'includes/db.php';

try {
    // First, let's check if the database connection works
    echo "Testing database connection...\n";
    $stmt = $pdo->query('SELECT 1');
    echo "Database connection successful!\n";
    
    // Check if tables exist
    $tables = ['users', 'employers', 'job_seekers', 'jobs', 'applications', 'interviews', 'notifications'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "Table '$table' exists\n";
        } else {
            echo "Table '$table' does NOT exist\n";
        }
    }
    
    // Create test employer user
    echo "\nCreating test employer user...\n";
    $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
    
    // Delete existing test data first
    $pdo->exec("DELETE FROM users WHERE email = 'employer@test.com'");
    
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)');
    $result = $stmt->execute(['Test Employer', 'employer@test.com', $hashedPassword, 'employer']);
    
    if ($result) {
        $userId = $pdo->lastInsertId();
        echo "Test employer user created with ID: $userId\n";
        
        // Create employer profile
        $stmt = $pdo->prepare('INSERT INTO employers (user_id, company_name, company_description, phone, position) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->execute([$userId, 'Test Company', 'A test company for testing purposes', '123-456-7890', 'HR Manager']);
        
        if ($result) {
            $employerId = $pdo->lastInsertId();
            echo "Employer profile created with ID: $employerId\n";
            
            // Create a test job
            $stmt = $pdo->prepare('INSERT INTO jobs (employer_id, title, description, location, salary, company_name, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
            $result = $stmt->execute([$employerId, 'Test Developer Position', 'A test job for testing purposes', 'Remote', '$50,000 - $60,000', 'Test Company']);
            
            if ($result) {
                $jobId = $pdo->lastInsertId();
                echo "Test job created with ID: $jobId\n";
                
                // Create test job seeker
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)');
                $result = $stmt->execute(['Test Job Seeker', 'jobseeker@test.com', $hashedPassword, 'job_seeker']);
                
                if ($result) {
                    $jobSeekerUserId = $pdo->lastInsertId();
                    echo "Job seeker user created with ID: $jobSeekerUserId\n";
                    
                    // Create job seeker profile
                    $stmt = $pdo->prepare('INSERT INTO job_seekers (user_id, skills, experience, education) VALUES (?, ?, ?, ?)');
                    $result = $stmt->execute([$jobSeekerUserId, 'PHP, JavaScript, MySQL', '2 years', 'Bachelor Degree']);
                    
                    if ($result) {
                        $jobSeekerId = $pdo->lastInsertId();
                        echo "Job seeker profile created with ID: $jobSeekerId\n";
                        
                        // Create test applications
                        $stmt = $pdo->prepare('INSERT INTO applications (job_id, seeker_id, status, applied_at) VALUES (?, ?, ?, NOW())');
                        
                        // Application without interview
                        $result = $stmt->execute([$jobId, $jobSeekerId, 'pending']);
                        if ($result) {
                            $app1Id = $pdo->lastInsertId();
                            echo "Application 1 (no interview) created with ID: $app1Id\n";
                        }
                        
                        // Application with interview
                        $result = $stmt->execute([$jobId, $jobSeekerId, 'accepted']);
                        if ($result) {
                            $app2Id = $pdo->lastInsertId();
                            echo "Application 2 (with interview) created with ID: $app2Id\n";
                            
                            // Create interview for application 2
                            $stmt = $pdo->prepare('INSERT INTO interviews (application_id, employer_id, job_seeker_id, job_id, interview_date, interview_time, location_medium, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
                            $result = $stmt->execute([$app2Id, $employerId, $jobSeekerId, $jobId, '2024-01-15', '10:00:00', 'Zoom Meeting', 'scheduled']);
                            
                            if ($result) {
                                $interviewId = $pdo->lastInsertId();
                                echo "Interview created with ID: $interviewId\n";
                            }
                        }
                    }
                }
            }
        }
    }
    
    echo "\nTest data creation completed!\n";
    echo "Login credentials: employer@test.com / password123\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
