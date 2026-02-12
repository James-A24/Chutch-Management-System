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
    <link rel="stylesheet" href="Dashboard.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
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
                <span></span>
                <h2>Dashboard</h2>
            </div>
        <div class ="user--info">
            <img src="icons/admin icon.png" style="width:42px;height:42px;">    
        </div>
    </div>
    

    <div class="card--container">
        <h3 class="main--title">Church Data</h3>

<!--TOTAL MEMBERS-->    
        <?php
include('connect.php');

$sql = "SELECT COUNT(*) as totalMembers FROM member";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    // Get the total number of members from the array
    $totalMembers = $row['totalMembers'];

    // Output the total number of members in your HTML
    echo '<div class="card--wrapper">
            <div class="members--card">
                <div class="class--header">
                    <div class="total">
                        <span class="title">Total Members</span>
                    </div>
                    <span class="total--members">' . $totalMembers . '</span>
                </div>
        </div>';
} else {
    // If there was an error in the query, display an error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>


<!--ACTIVE MEMBERS-->    
<?php
include('connect.php');

$sql = "SELECT COUNT(*) as activeMembers FROM member WHERE status = 'Active'";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    // Get the total number of members from the array
    $activeMembers = $row['activeMembers'];

    // Output the total number of members in your HTML
    echo '<div class="members--card">
                <div class="class--header">
                    <div class="total">
                        <span class="title">Active Members</span>
                    </div>
                    <span class="total--members">' . $activeMembers . '</span>
                </div>
        </div>';
} else {
    // If there was an error in the query, display an error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<br>

<!--FUNDS-->
<?php
include('connect.php');

$sql = "SELECT
        (SELECT SUM(cost_budget) FROM expense) AS total_exp, 
        (SELECT SUM(total) FROM income) AS total_inc,
        (SELECT SUM(total) FROM income) - (SELECT SUM(cost_budget) FROM expense) AS balance;";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    // Get the total number of groups from the array
    $balance = $row['balance'];

    $formattedBalance = 'kshs ' . number_format($balance, 0);

    // Output the total number of members in your HTML
    echo '<div class="members--card">
                <div class="class--header">
                <br>
                    <div class="total">
                        <span class="title">Available Funds</span>
                    </div>
                    <span class="total--members">' . $formattedBalance. '</span>
                </div>
        </div>';
} else {
    // If there was an error in the query, display an error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


<!--Groups-->
<?php
include('connect.php');

$sql = "SELECT COUNT(*) as groups FROM church_group WHERE status = 'Active'";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    // Get the total number of groups from the array
    $groups = $row['groups'];

    // Output the total number of members in your HTML
    echo '<div class="members--card">
                <div class="class--header">
                    <div class="total">
                        <span class="title">Groups</span>
                    </div>
                    <span class="total--members">' . $groups . '</span>
                </div>
        </div>';
} else {
    // If there was an error in the query, display an error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</div>
</div>


<div class ="tabular--wrapper">
    <h3 class="main--title">Updates</h3>
    <div class ="table--container">

    <div class ="card--container">
            <h3 class ="main--title"></h3>
                <form method="post" action="">

                    <div class="notification">
                    <ul>
                    <li> <h3>Latest Upcoming Events:</h3> </li>
                    <br>
                        <?php
                            include('connect.php');

                            $sql = "SELECT event_name, event_date
                                    FROM event 
                                    ORDER BY event_date DESC
                                    LIMIT 1";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $event_name = $row['event_name'];
                                $event_date = $row['event_date'];

                                // Output the latest member's name in your HTML
                                echo "<p>$event_name <br/> $event_date</p>";
                            } else {
                                // If there was no active member found, you can display a message
                                echo "No active members found.";
                            }

                            $conn->close();
                        ?>
                    </ul>
                    </div>
                    <br> 
                    <br> <br>

                    
                    <div class="notification">
                    <ul>
                        <li> <h3>Latest Added Member:</h3> </li>
                    <br>
                        <?php
                            include('connect.php');

                            $sql = "SELECT first_name, last_name
                                    FROM member 
                                    WHERE status = 'Active'
                                    ORDER BY id DESC
                                    LIMIT 1";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];

                                // Output the latest member's name in your HTML
                                echo "<p>$first_name $last_name</p>";
                            } else {
                                // If there was no active member found, you can display a message
                                echo "No active members found.";
                            }

                            $conn->close();
                        ?>
                    </div>
                    </ul>
                    <br> 
                    <br> <br>
                    
                        
                    
                    <div class="notification">
                    <ul>
                    <li> <h3>Newest Added Group:</h3> </li>
                    <br>
                        <?php
                            include('connect.php');

                            $sql = "SELECT name
                                    FROM church_group
                                    WHERE status = 'Active'
                                    ORDER BY id DESC
                                    LIMIT 1";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $name = $row['name'];

                                // Output the latest member's name in your HTML
                                echo "<p>$name</p>";
                            } else {
                                // If there was no active member found, you can display a message
                                echo "No active members found.";
                            }

                            $conn->close();
                        ?>
                    </div>
                    </ul>
                    <br> 
                    <br> <br>
                   
    </div>
    </div>
</body> 
</html>

<style>
        ul {
        list-style: none;
        padding: 12px;
        }

    .notification {
        background: rgb(229, 223, 223); /* Background color of the bubble */
        color: black; /* Text color */
        padding: 12px; /* Padding inside the bubble */
        border-radius: 6px; /* Rounded corners for the bubble */
        width: 600px; /* Adjust the width as needed */
        position: relative;
        transition: all 0.6s ease-in-out;
    }

    .notification:hover {
    transform: translateY(6px);
}


    .notification::before {
        content: "";
        position: absolute;
        top: 50%;
        right: 100%; /* Positioned to the left of the bubble */
        margin-top: -5px; /* Half the height of the bubble */
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent transparent #3498db; /* Triangle on the left */
    }
</style>