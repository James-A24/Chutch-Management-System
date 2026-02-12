<?php
include('connect.php');

if (isset($_POST['cancel_event'])) {
    $eventId = $_POST['event_id'];

    $updateQuery = "UPDATE event SET start_time= NULL, finish_time  = NULL WHERE id = $eventId";

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: Events Tab.php"); // Redirect back to the form after submission
        exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    $conn->close();
    ?>
