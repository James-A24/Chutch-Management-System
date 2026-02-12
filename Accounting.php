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
    <link rel="stylesheet" href="accounting.css"/>
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
                <span> </span>
                <h2>Accounting</h2>
            </div>
        <div class ="user--info">
            <div class="search--box">
            </div>
                <img src="icons/admin icon.png" style="width:42px;height:42px;">  
    </div>
    </div>


<div class ="tabular--wrapper">
    <h3 class ="main--title">Income</h3>

    <!-- A button to open the popup form -->
<button class="open-button" onclick="openForm()">Add </button>

<!-- Pop-Up form -->
<div class="form-popup" id="myForm">
    <form action="add_income.php" method="post" class="form-container">
    </br>

    <label for="income_source">Income source: </label>
    <select id="ocassion" name="income_source">
      <option value="" disabled selected>Select an income source</option>
      <option value="Wedding">Wedding</option>
      <option value="Church service">Church Service</option>
      <option value="Fundraiser">Fundraiser</option>
    </select> <br> 

    <label for="income_typee">Income type:</label>
    <select id="ocassion" name="income_type">
    <option value="" disabled selected>Select the income type</option>
      <option value="Offering">Offering</option>
      <option value="Tithe">Tithe</option>
      <option value="Donation">Donation</option>
      <option value="Contribution">Contribution</option>
    </select> <br>

    <label for="date">Date</label>
    <input type="date" placeholder="date" name="date" required>

    <label for="total">Total Contribution</label>
    <input type="number" placeholder="Total" name="total" required>


    <button type="submit" class="btn">Add </button>
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


<!--TABLE-->
<div class="table--container">
        <table>
            <thead>
                <tr>
                    <th>Income Source</th>
                    <th>Income Type</th>
                    <th>Date</th>
                    <th>Total Contribution/Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include('connect.php');

            // Fetch data from the database
            $result = $conn->query("SELECT * FROM income");

            $totals = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $totals += $row['total'];
                    echo "<tr>
                            <td>{$row['income_source']}</td>
                            <td>{$row['income_type']}</td>
                            <td>{$row['date']}</td>
                            <td>{$row['total']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong><?php echo $totals; ?></strong></td>
            </tr>
            </tfoot>        
    </table>

    </div>
    </div>
    <br>

<div class ="tabular--wrapper">
    <h3 class="main--title"> Expenses </h3>


<!-- A button to open the popup form -->
<button class="open-button" onclick="openForm2()">Add Expense</button>

<!-- Pop-Up form -->
<div class="form-popup" id="myForm2">
  <form action="add_expense.php" method="post" class="form-container">
    </br>

    <label for="expense_type">Expense Type:</label>
    <select id="expense_type" name="expense_type">
    <option value="" disabled selected>Choose between a Product/Service</option>
    <option value="Product">Product</option>
    <option value="Service">Service</option>
    </select>

    <label for="cost_budget">Cost/Budget</label>
    <input type="number" placeholder="Cost/Budget" name="cost_budget" required>

    <label for="date">Date</label>
    <input type="date" placeholder="Date" name="date" required>

    <label for="description">Description</label>
    <textarea placeholder="Enter a detailed description" name="description"></textarea>

    <button type="submit" class="btn">Add </button>
    <br> <br>    
    <button type="button" class="btn" onclick="closeForm2()">Close</button>
  </form>

</div>

<script>
    function openForm2() {
    document.getElementById("myForm2").style.display = "block";
  }
  
  function closeForm2() {
    document.getElementById("myForm2").style.display = "none";
  }
  </script>


<div class="Table container">
        <table>
            <thead>
                <tr>
                    <th>Expense type</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Cost/Budget</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('connect.php');

                // Fetch data from the database
                $result = $conn->query("SELECT * FROM expense");

                $totalCost = 0; // Initialize total cost variable

                if ($result->num_rows > 0) {
                     while ($row = $result->fetch_assoc()) {
                $totalCost += $row['cost_budget']; // Accumulate total cost
                echo "<tr>
                        <td>{$row['expense_type']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['cost_budget']}</td>
                      </tr>";
                    }
                } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong><?php echo $totalCost; ?></strong></td>
                </tr>
                </tfoot>    
        </table>
    
    </div>
    </div>
    <br>

    