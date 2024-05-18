<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://ansarportal-deaa9ded50c7.herokuapp.com/admin/css/admim_style.css">
</head>

<body class="register-body">
    <div class="container">
        <form id="registerForm" action="" method="post">
            <h2>Register</h2>
            <label for="registration_code">Registration Code:</label>
            <input type="text" id="registration_code" name="registration_code" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://ansarportal-deaa9ded50c7.herokuapp.com/admin/js/admin_script.js"></script>
</body>

</html>