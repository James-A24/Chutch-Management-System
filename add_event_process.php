<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $finish_time = $_POST['finish_time'];

    
    $sql = "INSERT INTO event (event_name, event_date, start_time, finish_time)
     VALUES ('$event_name', '$event_date', '$start_time', '$finish_time')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Events Tab.php"); // Redirect back to the form after submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
