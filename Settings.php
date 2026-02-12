<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Sign-In Page.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    echo '<script> alert("You have been Logged Out...")
            window.location.href = "Dashboard.php";</script>';
    exit();
}

// Handle report generation
if (isset($_POST['generateReport'])) {
    include 'generate_report.php';
    
    echo '<button onclick="window.print()">Print Report</button>';
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
                <h2>More Options</h2>
            </div>
        <div class ="user--info">
            <div class="search--box">
            </div>
            <img src="icons/admin icon.png" style="width:42px;height:42px;">   
        </div>
    </div>
    

        <div class ="card--container">
            <h3 class ="main--title"></h3>
                <form method="post" action="">
                    <br>
                    <ul>
                        <li> Sign out Here </li>
                    <br> 
                    <button type="submit" name="logout" 
                    style="background-color: #0077b6; color: white; padding: 6px 12px; border: none; 
                           border-radius: 3px; cursor: pointer;">Sign Out</button>
                    <br> <br>

                    <li>Produce Report </li>
                    <br>

                    <!-- Create a form that submits a request to generate the report -->
                    <form id="reportForm" action="generate_report.php" method="post">
                        <button type="submit" name="generateReport" style="background-color: #0077b6; color: white; 
                        padding: 6px 12px; border: none; border-radius: 3px; cursor: pointer;">Report</button>
                    </form>
                    <br> <br>
                    </form>
                    </ul>

    <style>
        ul {
        list-style: none;
        padding: 12px;
        }
    </style>

    

    