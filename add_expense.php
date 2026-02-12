<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_type = $_POST['expense_type'];
    $cost_budget= $_POST['cost_budget'];
    $date = $_POST['date'];
    $description = $_POST['description'];


    $sql = "INSERT INTO expense (expense_type, cost_budget, date, description) 
            VALUES ('$expense_type', '$cost_budget', '$date', '$description')";

if ($conn->query($sql) === TRUE) {
    header("Location: accounting.php"); // Redirect back to the form after submission
    exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
