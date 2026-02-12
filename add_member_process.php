<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name']; 
    $last_name = $_POST['last_name'];   
    $surname = $_POST['surname'];       
    $email_address = $_POST['email_address'];   
    $status = $_POST['status'];         

    $sql = "INSERT INTO member (first_name, last_name, surname, email_address, status) 
            VALUES ('$first_name', '$last_name', '$surname', '$email_address', '$status')";

if ($conn->query($sql) === TRUE) {
    header("Location: People and Groups.php"); // Redirect back to the form after submission
    exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
