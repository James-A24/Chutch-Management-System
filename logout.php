 <?php
        session_start(); // Start the session
        session_destroy(); // Destroy the session
        header("Location: Sign-In Page.php"); // Redirect to the login page
        exit();
?>