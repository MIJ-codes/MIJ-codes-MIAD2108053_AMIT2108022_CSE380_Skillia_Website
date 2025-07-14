<?php
require_once 'includes/db.php';

try {
    // Check if test users exist
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email IN (?, ?)');
    $stmt->execute(['employer@test.com', 'jobseeker@test.com']);
    $users = $stmt->fetchAll();
    
    echo "Users found: " . count($users) . "\n";
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Email: {$user['email']}, Type: {$user['user_type']}\n";
    }
    
    // Check employers
    $stmt = $pdo->prepare('SELECT * FROM employers WHERE user_id = 100');
    $stmt->execute();
    $employer = $stmt->fetch();
    
    if ($employer) {
        echo "\nEmployer found: ID {$employer['id']}, Company: {$employer['company_name']}\n";
    } else {
        echo "\nNo employer found for user_id 100\n";
    }
    
    // Check job seekers
    $stmt = $pdo->prepare('SELECT * FROM job_seekers WHERE user_id = 101');
    $stmt->execute();
    $jobSeeker = $stmt->fetch();
    
    if ($jobSeeker) {
        echo "Job Seeker found: ID {$jobSeeker['id']}\n";
    } else {
        echo "No job seeker found for user_id 101\n";
    }
    
    // Check jobs
    $stmt = $pdo->prepare('SELECT * FROM jobs WHERE id = 200');
    $stmt->execute();
    $job = $stmt->fetch();
    
    if ($job) {
        echo "Job found: ID {$job['id']}, Title: {$job['title']}\n";
    } else {
        echo "No job found with ID 200\n";
    }
    
    // Check applications
    $stmt = $pdo->prepare('SELECT * FROM applications WHERE id IN (300, 301)');
    $stmt->execute();
    $applications = $stmt->fetchAll();
    
    echo "Applications found: " . count($applications) . "\n";
    foreach ($applications as $app) {
        echo "App ID: {$app['id']}, Status: {$app['status']}\n";
    }
    
    // Check interviews
    $stmt = $pdo->prepare('SELECT * FROM interviews WHERE id = 400');
    $stmt->execute();
    $interview = $stmt->fetch();
    
    if ($interview) {
        echo "Interview found: ID {$interview['id']}, Status: {$interview['status']}\n";
    } else {
        echo "No interview found with ID 400\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
