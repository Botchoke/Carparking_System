<?php
include "db.php";

$username = trim($_POST['username']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

/* Check if passwords match */
if($password !== $confirm_password){

    header("Location: register.php?error=Passwords do not match");
    exit();
}

/* Strong password validation */
if(
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[^A-Za-z0-9]/', $password)
){

    header("Location: register.php?error=Password must contain uppercase, lowercase, number and special character");
    exit();
}

/* Check if username already exists */
$check = mysqli_query(
    $conn,
    "SELECT id FROM users WHERE username='$username'"
);

if(mysqli_num_rows($check) > 0){

    header("Location: register.php?error=Username already exists");
    exit();
}

/* Hash password */
$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

/* Save user */
$sql = "INSERT INTO users(username,password)
        VALUES('$username','$hashedPassword')";

if(mysqli_query($conn,$sql)){

    header("Location: register.php?success=1");
    exit();

}else{

    header("Location: register.php?error=Registration failed");
    exit();
}
?>
