<?php
// Migration: Add name, job_title, company, image_url columns to success_stories
$host = 'localhost';
$dbname = 'skillia';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE success_stories 
        ADD COLUMN name VARCHAR(255) AFTER seeker_id,
        ADD COLUMN job_title VARCHAR(255) AFTER name,
        ADD COLUMN company VARCHAR(255) AFTER job_title,
        ADD COLUMN image_url TEXT AFTER story";
    $pdo->exec($sql);
    echo "Migration successful: Columns added to success_stories table.";
} catch(PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
} 