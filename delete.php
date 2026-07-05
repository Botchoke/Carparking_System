<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Get vehicle information
$get = mysqli_query($conn, "SELECT * FROM vehicles WHERE id='$id'");

if (mysqli_num_rows($get) == 0) {
    header("Location: index.php");
    exit();
}

$row = mysqli_fetch_assoc($get);

$plate = $row['plate_number'];
$owner = $row['owner_name'];
$slot = $row['slot_number'];
$time_in = $row['time_in'];

$time_out = date("Y-m-d H:i:s");

// Calculate parking time
$seconds = strtotime($time_out) - strtotime($time_in);
$minutes = ceil($seconds / 60);

if ($minutes < 1) {
    $minutes = 1;
}

/*
|--------------------------------------------------------------------------
| CHANGE YOUR PARKING RATE HERE
|--------------------------------------------------------------------------
*/

// Example: ₱20 per minute
$ratePerMinute = 20;

// Calculate total fee
$total_fee = $minutes * $ratePerMinute;

// Save to history
mysqli_query($conn, "
INSERT INTO history
(plate_number, owner_name, slot_number, time_in, time_out, total_fee)
VALUES
('$plate','$owner','$slot','$time_in','$time_out','$total_fee')
");

// Remove active vehicle
mysqli_query($conn, "DELETE FROM vehicles WHERE id='$id'");

header("Location: index.php");
exit();
?>