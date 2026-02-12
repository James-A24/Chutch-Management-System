<?php
$servername = "localhost";
$username = "church_management";
$password = "zkk7)Nl7]uLf2lda"; 
$database = "church_management"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
