<?php
// Database connection
$host = 'localhost';
$dbname = 'skillia';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.<br>";
    
    // Create interviews table
    $interviews_sql = "CREATE TABLE IF NOT EXISTS interviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        application_id INT NOT NULL,
        employer_id INT NOT NULL,
        job_seeker_id INT NOT NULL,
        job_id INT NOT NULL,
        interview_date DATE NOT NULL,
        interview_time TIME NOT NULL,
        location_medium VARCHAR(255) NOT NULL,
        notes TEXT,
        status ENUM('scheduled', 'completed', 'cancelled', 'rescheduled') DEFAULT 'scheduled',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE,
        FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
        FOREIGN KEY (job_seeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE,
        FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
    )";
    
    $pdo->exec($interviews_sql);
    echo "Interviews table created successfully.<br>";
    
    // Create notifications table
    $notifications_sql = "CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        user_type ENUM('job_seeker', 'employer') NOT NULL,
        title VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        type ENUM('application_status', 'interview_scheduled', 'interview_updated', 'interview_cancelled', 'message', 'system') NOT NULL,
        related_id INT,
        related_type ENUM('application', 'interview', 'job', 'message') NOT NULL,
        is_read BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES job_seekers(id) ON DELETE CASCADE
    )";
    
    $pdo->exec($notifications_sql);
    echo "Notifications table created successfully.<br>";
    
    // Add indexes for better performance
    $indexes = [
        "CREATE INDEX idx_interviews_application ON interviews(application_id)",
        "CREATE INDEX idx_interviews_employer ON interviews(employer_id)",
        "CREATE INDEX idx_interviews_job_seeker ON interviews(job_seeker_id)",
        "CREATE INDEX idx_interviews_date ON interviews(interview_date)",
        "CREATE INDEX idx_notifications_user ON notifications(user_id, user_type)",
        "CREATE INDEX idx_notifications_read ON notifications(is_read)",
        "CREATE INDEX idx_notifications_created ON notifications(created_at)"
    ];
    
    foreach ($indexes as $index_sql) {
        try {
            $pdo->exec($index_sql);
        } catch (PDOException $e) {
            // Index might already exist, continue
        }
    }
    
    echo "Indexes created successfully.<br>";
    echo "<strong>Database setup completed successfully!</strong><br>";
    echo "<a href='../pages/employer-dashboard.php'>Go to Employer Dashboard</a> | ";
    echo "<a href='../pages/job-seeker-dashboard.php'>Go to Job Seeker Dashboard</a>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 