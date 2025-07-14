<?php
require_once '../includes/db.php';

$columns = [
    'title' => "ALTER TABLE job_seekers ADD COLUMN title VARCHAR(100) DEFAULT NULL",
    'expected_salary' => "ALTER TABLE job_seekers ADD COLUMN expected_salary VARCHAR(50) DEFAULT NULL",
    'languages' => "ALTER TABLE job_seekers ADD COLUMN languages VARCHAR(255) DEFAULT NULL",
    'github' => "ALTER TABLE job_seekers ADD COLUMN github VARCHAR(255) DEFAULT NULL"
];

foreach ($columns as $col => $sql) {
    $exists = $pdo->query("SHOW COLUMNS FROM job_seekers LIKE '$col'")->fetch();
    if (!$exists) {
        try {
            $pdo->exec($sql);
            echo "Added column: $col<br>";
        } catch (PDOException $e) {
            echo "Error adding $col: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "Column $col already exists.<br>";
    }
}
echo "<strong>Migration complete.</strong>";
?> 