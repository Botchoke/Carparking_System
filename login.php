<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hypercar Parking Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-page">

    <div class="login-container">

        <h1>⚡ Hypercar Parking</h1>

        <form action="login_process.php" method="POST">

            <input
                type="text"
                name="username"
                placeholder="Username"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <?php
            if(isset($_GET['error'])){
                echo "<p style='color:red;margin:10px 0;'>Invalid username or password</p>";
            }
            ?>

            <button class="login-btn" type="submit">
                Login
            </button>

        </form>

        <p class="register-text">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

    </div>

</div>

</body>
</html>