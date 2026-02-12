<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $group_name = $_POST['group_name'];
    $role = $_POST['role'];

    // Function to get the group_id based on the group_name
    $group_id = getGroupIdByName($group_name);

    if ($group_id !== false) {
        $check_query = "SELECT * FROM member_group WHERE member_id = '$member_id' AND group_id = '$group_id'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0) {
            // If the record exists, update the role
            $update_query = "UPDATE member_group SET role = '$role' WHERE member_id = '$member_id' AND group_id = '$group_id'";

            if ($conn->query($update_query) === TRUE) {
                header("Location: manage.php");
                exit();
            } else {
                $error_message = "Error updating record: " . $conn->error;
            }
        } else {
            // If no record exists, insert a new record
            $insert_query = "INSERT INTO member_group (member_id, group_id, role) VALUES ('$member_id', '$group_id', '$role')";

            if ($conn->query($insert_query) === TRUE) {
                header("Location: manage.php");
                exit();
            } else {
                $error_message = "Error inserting record: " . $conn->error;
            }
        }
    } else {
        $error_message = "Group not found.";
    }
} else {
    $error_message = "Invalid input data. Please make sure all fields are filled.";
}

$conn->close();

function getGroupIdByName($group_name) {
    global $conn;

    // Implement your database query here to retrieve the group_id based on the group_name
    $query = "SELECT id FROM church_group WHERE name = '$group_name'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }
    return false;
}
?>
