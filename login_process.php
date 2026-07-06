<?php
session_start();
include "db.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get the user by username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if (password_verify($password, $row['password'])) {

            $_SESSION['user'] = $username;

            header("Location: index.php");
            exit();

        } else {

            header("Location: login.php?error=1");
            exit();

        }

    } else {

        header("Location: login.php?error=1");
        exit();

    }

} else {

    header("Location: login.php");
    exit();

}
?>
