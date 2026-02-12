<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $income_source = $_POST['income_source'];
    $income_type = $_POST['income_type'];
    $date = $_POST['date'];
    $total = $_POST['total'];


    $sql = "INSERT INTO income (income_source, income_type, date, total) 
            VALUES ('$income_source', '$income_type', '$date', '$total')";

    if ($conn->query($sql) === TRUE) {
        header("Location: accounting.php"); // Redirect back to the form after submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
