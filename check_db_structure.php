<?php
require_once 'includes/db.php';

// Create success_stories table if not exists
$sql = "CREATE TABLE IF NOT EXISTS success_stories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  job_title VARCHAR(100) NOT NULL,
  company VARCHAR(100) NOT NULL,
  story TEXT NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$pdo->exec($sql);
echo "success_stories table checked/created.\n";

echo "Checking job_seekers table structure...\n";

try {
    // Check current structure
    $stmt = $pdo->query("DESCRIBE job_seekers");
    $columns = $stmt->fetchAll();
    
    echo "Current columns:\n";
    $existing_columns = [];
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . "\n";
        $existing_columns[] = $column['Field'];
    }
    
    // Define missing columns
    $missing_columns = [
        'photo' => 'VARCHAR(255) DEFAULT NULL',
        'phone' => 'VARCHAR(20) DEFAULT NULL',
        'linkedin' => 'VARCHAR(255) DEFAULT NULL',
        'portfolio' => 'VARCHAR(255) DEFAULT NULL'
    ];
    
    echo "\nAdding missing columns...\n";
    
    foreach ($missing_columns as $column_name => $column_def) {
        if (!in_array($column_name, $existing_columns)) {
            $sql = "ALTER TABLE job_seekers ADD COLUMN $column_name $column_def";
            $pdo->exec($sql);
            echo "Added column: $column_name\n";
        } else {
            echo "Column $column_name already exists\n";
        }
    }
    
    echo "\nDatabase structure updated successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Run this script once to update the database structure for locations and experience levels
require_once 'includes/db.php';

try {
    // 1. Create locations table
    $pdo->exec("CREATE TABLE IF NOT EXISTS locations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Create experience_levels table
    $pdo->exec("CREATE TABLE IF NOT EXISTS experience_levels (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Insert default locations if not exists
    $defaultLocations = ['Remote', 'On-site', 'Hybrid'];
    foreach ($defaultLocations as $loc) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO locations (name) VALUES (?)");
        $stmt->execute([$loc]);
    }

    // 4. Insert default experience levels if not exists
    $defaultExp = ['Entry Level', 'Mid Level', 'Senior Level'];
    foreach ($defaultExp as $exp) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO experience_levels (name) VALUES (?)");
        $stmt->execute([$exp]);
    }

    // 5. Add location_id and experience_level_id columns to jobs table if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM jobs")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('location_id', $cols)) {
        $pdo->exec("ALTER TABLE jobs ADD COLUMN location_id INT NULL AFTER location");
    }
    if (!in_array('experience_level_id', $cols)) {
        $pdo->exec("ALTER TABLE jobs ADD COLUMN experience_level_id INT NULL AFTER salary");
    }

    // 6. Add job_type column if not exists (for completeness)
    if (!in_array('job_type', $cols)) {
        $pdo->exec("ALTER TABLE jobs ADD COLUMN job_type VARCHAR(50) NULL AFTER experience_level_id");
    }

    // 7. Add foreign key constraints (if not already present)
    $pdo->exec("ALTER TABLE jobs ADD CONSTRAINT IF NOT EXISTS fk_jobs_location_id FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL");
    $pdo->exec("ALTER TABLE jobs ADD CONSTRAINT IF NOT EXISTS fk_jobs_experience_level_id FOREIGN KEY (experience_level_id) REFERENCES experience_levels(id) ON DELETE SET NULL");

    echo "Database structure updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 