<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

if (isset($_GET['exit_id'])) {

    $id = intval($_GET['exit_id']);

    // Get vehicle data
    $query = mysqli_query($conn, "SELECT * FROM vehicles WHERE id='$id'");

    if (!$query || mysqli_num_rows($query) == 0) {
        die("Vehicle not found.");
    }

    $row = mysqli_fetch_assoc($query);

    $plate = $row['plate_number'];
    $owner = $row['owner_name'];
    $slot = $row['slot_number'];
    $time_in = $row['time_in'];

    $time_out = date("Y-m-d H:i:s");

// Calculate parking duration
$seconds = strtotime($time_out) - strtotime($time_in);
$minutes = max(1, ceil($seconds / 120));

// Parking rate (₱20 per minute)
$ratePerMinute = 50;
$total_fee = $minutes * $ratePerMinute;

    // Save to history
    $insert = mysqli_query($conn, "
        INSERT INTO history
        (plate_number, owner_name, slot_number, time_in, time_out, total_fee)
        VALUES
        ('$plate', '$owner', '$slot', '$time_in', '$time_out', '$total_fee')
    ");

    if (!$insert) {
        die("History Insert Error: " . mysqli_error($conn));
    }

    // Delete from active vehicles
    mysqli_query($conn, "DELETE FROM vehicles WHERE id='$id'");

    header("Location: index.php");
exit();
}
?>