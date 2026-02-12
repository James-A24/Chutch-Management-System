<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = $_POST['group_id'];
    $group_name = $_POST['name'];
    $status = $_POST['status'];

        // Update the data in the database
    $sql = "UPDATE church_group SET name = '$group_name',status = '$status'
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
