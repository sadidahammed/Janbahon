<?php
$servername = "localhost";
$username = "root";
$password = "";

// Database and table creation
try {
    // Connect to MySQL
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $dbName = "zanbahon";
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbName");
    $conn->exec("USE $dbName");

    // Create users table
    $sqlUsers = "CREATE TABLE IF NOT EXISTS Users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name CHAR(255) NOT NULL,
        date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        review INT(5) DEFAULT 0
    )";
    $conn->exec($sqlUsers);

    // Create drivers table
    $sqlDrivers = "CREATE TABLE IF NOT EXISTS Drivers (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name CHAR(255) NOT NULL,
        date_of_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        review INT(5) DEFAULT 0
    )";
    $conn->exec($sqlDrivers);

    // Create reservation table
    $sqlReservation = "CREATE TABLE IF NOT EXISTS Reservation_Table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pickup_location VARCHAR(255) NOT NULL,
        destination VARCHAR(255) NOT NULL,
        vehicle_type VARCHAR(255) NOT NULL,
        payment_method VARCHAR(255) NOT NULL,
        userID INT,
        driverID INT,
        status VARCHAR(50) NOT NULL,
        trip_start TIME,
        trip_end TIME,
        FOREIGN KEY (userID) REFERENCES users(Id),
        FOREIGN KEY (driverID) REFERENCES drivers(id)
    )";
    $conn->exec($sqlReservation);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
