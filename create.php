<?php
include "db.php";


$sql1="CREATE TABLE IF NOT EXISTS users(
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50),
password VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";


$sql2="CREATE TABLE IF NOT EXISTS vehicles(
id INT AUTO_INCREMENT PRIMARY KEY,
plate_number VARCHAR(20),
owner_name VARCHAR(100),
slot_number INT,
time_in DATETIME DEFAULT CURRENT_TIMESTAMP,
fee INT DEFAULT 25
)";


$sql3="CREATE TABLE IF NOT EXISTS history(
id INT AUTO_INCREMENT PRIMARY KEY,
plate_number VARCHAR(20),
owner_name VARCHAR(100),
slot_number INT,
time_in DATETIME,
time_out DATETIME,
total_fee INT
)";


mysqli_query($conn,$sql1);
mysqli_query($conn,$sql2);
mysqli_query($conn,$sql3);


echo "Tables created successfully";
?>

