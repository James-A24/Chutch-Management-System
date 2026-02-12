<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>B.C.M.S| Sign in</title>
    <link rel="stylesheet" href="Sign-In Page.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
        $username = "admin";
        $password = "Letmein1";

        if ($_POST["username"] === $username && $_POST["password"] === $password) {
            // Authentication successful, start a session and redirect
            session_start();
            $_SESSION["user_id"] = 1; // Store user ID or other relevant data

            // Use JavaScript to display a success message
            echo '<script> alert("Login was successful. Redirecting to the dashboard...")
            window.location.href = "Dashboard.php";</script>';
            exit();
        } else {
            echo '<script> alert("Wrong Password/Username not successful. Cannot access this website...");</script>';
        }
    }
    ?>

    <form id="loginForm" method="POST">
        <h2>Administration Login Form</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <span class="toggle-password" onclick="togglePassword()">
            <i class="fas fa-eye" id="eye-icon"> Show Password</i>
        </span> 
        <br> <br>
        <input type="submit" value="Login">
    </form>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
