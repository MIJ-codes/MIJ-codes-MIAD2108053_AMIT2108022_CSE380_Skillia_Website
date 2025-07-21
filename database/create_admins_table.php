<?php
// Include DB connection
require_once __DIR__ . '/../includes/db.php';

// Create admins table if not exists
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
    echo "Admins table created or already exists.<br>";
} else {
    echo "Error creating admins table: " . $conn->error . "<br>";
}

// Insert default admin if not exists
$default_username = 'admin';
$default_password = password_hash('admin123', PASSWORD_DEFAULT);

// Check if admin exists
$stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
$stmt->bind_param('s', $default_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $default_username, $default_password);
    if ($stmt->execute()) {
        echo "Default admin user created. Username: admin, Password: admin123<br>";
    } else {
        echo "Error inserting default admin: " . $stmt->error . "<br>";
    }
} else {
    echo "Default admin user already exists.<br>";
}
$stmt->close();
$conn->close(); 