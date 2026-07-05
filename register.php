<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">

    <?php
    if(isset($_GET['success'])){
        echo '<div class="success-message">✓ Account created successfully!</div>';
    }
    ?>

    <h1>Create Account</h1>

    <form action="register_process.php" method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="login-btn">Register</button>

    </form>

    <p class="register-text">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>