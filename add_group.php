<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $status= $_POST['status'];

    $sql = "INSERT INTO church_group (name, status) 
            VALUES ('$name', '$status')";

if ($conn->query($sql) === TRUE) {
    header("Location: People and Groups.php"); // Redirect back to the form after submission
    exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
