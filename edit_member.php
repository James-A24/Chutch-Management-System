<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $surname = $_POST['surname'];
    $email_address = $_POST['email_address'];
    $status = $_POST['status'];

        // Update the data in the database
    $sql = "UPDATE member SET first_name = '$first_name',
            last_name = '$last_name', surname = '$surname',
            email_address = '$email_address',status = '$status'
            WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: People and Groups.php"); // Redirect back to the form after submission
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
}

$conn->close();
?>
