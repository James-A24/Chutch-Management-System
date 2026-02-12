<?php
// Start the session
session_start();

// Check if the user is not logged in (session variable is not set)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other appropriate destination
    header("Location: Sign-In Page.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>B.C.M.S | Dashboard</title>
    <link rel="stylesheet" href="events.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
<div class="sidebar">
<div class="logo"></div>
        <ul class="menu">
            <br> <br> <br> <br>
            <li>
            <a href="Dashboard.php">
                <i class ="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                </a>
            </li>
            <br> 
            <li>
                <a href="People and Groups.php">
                    <i class ="fas fa-user"></i>
                    <span>People and Groups</span>
                    </a>
            </li>
            <br> 
            <li>
                <a href="Manage.php">
                    <i class ="fas fa-users"></i>
                    <span>Manage People</span>
                    </a>
            </li>
            <br>
            <li>
                <a href="Events Tab.php">
                    <i class="fas fa-calendar"></i>
                    <span>Events</span>
                    </a>
            </li>
            <br> 

            <li>
                <a href="Accounting.php">
                    <i class ="fas fa-calculator"></i>
                    <span>Accounting and Budgeting</span>
                    </a>
            </li>
            <br> 

            <li>
                <a href="Settings.php">
                    <i class ="fas fa-cog"></i>
                    <span>More...</span>
                    </a>
            </li>
        </ul>
    </div>

    <div class="main--content">
        <div class ="header--wrapper">
            <div class ="header--title">
                <span> </span>
                <h2>Events</h2>
            </div>
        <div class ="user--info">
            <img src="icons/admin icon.png" style="width:42px;height:42px;">  
        </div>
        </div>

<div class ="tabular--wrapper">
    <h3 class ="main--title"> Add Event</h3>

    <!--Adding an Event-->
<!-- A button to open the popup form -->
<button class="open-button" onclick="openForm()">Add Event</button>

<!-- Pop-Up form -->
<div class="form-popup" id="myForm">
<form action="add_event_process.php" method="post" class="form-container">
    </br>
    
      <label for="event_name">Event Name</label>
      <input type="text" placeholder="Event Name" name="event_name" required>
  
      <label for="event_date">Event Date</label>
      <input type="date" name="event_date" required>
  
      <label for="start_time">Start Time</label>
      <input type="time" name="start_time">
  
      <label for="finish_time">Finish Time</label>
      <input type="time" name="finish_time">
  
      <button type="submit" class="btn">Add</button>
      <br> <br>
      <button type="button" class="btn" onclick="closeForm()">Close</button>
  </form> 
</div>

<script>
    function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }


</script>

</div>

<div class ="tabular--wrapper">
    <h3 class ="main--title">All Events</h3>
    

    <table id="eventTable">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Events Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>     
            <tbody>
    <?php
    include('connect.php');

    // Fetch data from the database
    $result = $conn->query("SELECT * FROM event");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['event_name']}</td>
                    <td>{$row['event_date']}</td>
                    <td>{$row['start_time']}</td>
                    <td>{$row['finish_time']}</td>
                    <td>";

            // Check if the start_time is not null
            if (!is_null($row['start_time'])) {
                echo "<form method='post' action='cancel_event.php'>
                        <input type='hidden' name='event_id' value='{$row['id']}'>
                        <button type='submit' name='cancel_event' 
                        style='background-color: #0077b6; color: white; padding: 6px 12px; border: none; border-radius: 3px; cursor: pointer;'>
                        Cancel
                        </button>
                    </form>";
            }

            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No Event found</td></tr>";
    }

    $conn->close();
    ?>
</tbody>
        </table>
    
    </div>
    </div>
    <br>

    