<?php
$host = "localhost";
$username = "root";
$password = ""; // Default XAMPP
$port = 3307;

// Create connection
$conn = new mysqli($host, $username, $password, "", $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS agrismart";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select database
$conn->select_db("agrismart");

// Create Users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    farm_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Insert admin user
$admin_password = password_hash("admin123", PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (firstname, lastname, farm_name, email, password, role) 
        VALUES ('Admin', 'System', 'Admin HQ', 'admin@souss-massa.ma', '$admin_password', 'admin')";
if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully\n";
} else {
    echo "Error inserting admin: " . $conn->error . "\n";
}

$conn->close();
?>
