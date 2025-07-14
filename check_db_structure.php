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
?> 