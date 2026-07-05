<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $plate = $_POST['plate'];
    $owner = $_POST['owner'];
    $slot = $_POST['slot'];

    $sql = "UPDATE vehicles
            SET plate_number='$plate',
                owner_name='$owner',
                slot_number='$slot'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>