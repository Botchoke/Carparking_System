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

    if(isset($_GET['error'])){
        echo '<div class="success-message" style="background:#dc2626;color:white;">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <h1>Create Account</h1>

    <form action="register_process.php" method="POST">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               id="password"
               placeholder="Password"
               required>

        <input type="password"
               name="confirm_password"
               id="confirm_password"
               placeholder="Confirm Password"
               required>
        <button type="submit" class="login-btn">
            Register
        </button>

    </form>

    <p class="register-text">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</div>


</body>
</html>
