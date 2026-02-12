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
    <title>B.C.M.S | Dashboard </title>
    <link rel="stylesheet" href="People.css"/>
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
                <h2>People and Groups</h2>
            </div>
        <div class ="user--info">
            <img src="icons/admin icon.png" style="width:42px;height:42px;">    
        </div>
        </div>

<!--PEOPLE-->
<div class ="tabular--wrapper">
    <h3 class="main--title"> People </h3> 
        <div class="search--box">
        <i class ="fa fa-search"></i>
        <input type="text" class="searchInput" data-table="peopleTable" placeholder="Search Person">
        </div> <br> 

        
<!-- People Pop-Up form below -->
<button class="open-button" onclick="openForm1()">Add Member</button>

<div class="form-popup" id="myForm">
   <form action="add_member_process.php" method="post" class="form-container">
   <h1>Add Member</h1>
    <br>

    <label for="first_name">First Name</label>
    <input type="text" placeholder="First Name" name="first_name" required>

    <label for="last_name">Last Name</label>
    <input type="text" placeholder="Last Name" name="last_name" required>

    <label for="surname">Surname</label>
    <input type="text" placeholder="Surname" name="surname">

    <label for="email_address">Email Address</label>
    <input type="email" placeholder="Email Address" name="email_address" required>

    <label for="status">Status </label>
    <select name="status" required>
    <option value="" disabled selected>Choose the Status</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select> <br> <br>

    <button type="submit" class="btn">Add </button>
    <br> <br>    
    <button type="button" class="btn" onclick="closeForm1()">Close</button>
  </form>  
</div>

<script>
    function openForm1() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm1() {
    document.getElementById("myForm").style.display = "none";
  }
  </script>


<!--Edit People Pop-up Form-->
<div class="form-popup" id="editForm">
    
   <form action="edit_member.php" method="post" class="form-container">
    <h1>Edit Member</h1>
    <br>
    <input type="hidden" name="user_id" id="editUserId" value="">

    <label for="first_name">First Name</label>
    <input type="text" placeholder="First Name" name="first_name" >

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name">

    <label for="surname">Surname</label>
    <input type="text" name="surname">

    <label for="email_address">Email Address</label>
    <input type="text" name="email_address">

    <label for="status">Status </label>
    <select name="status">
    <option value="" disabled selected>Choose the Status</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select> <br> <br>

    <button type="submit" class="btn">Update</button>
    <br> <br>
    <button type="button" class="btn" onclick="closeForm2()">Cancel</button>
   </form>
</div>

<script>
function editUser(id) {
    // Fetch the corresponding table row using the unique identifier
    var row = document.querySelector("tr[data-id='" + id + "']");
    
    // Populate the Edit People Pop-up Form fields
    document.querySelector("#editForm [name='first_name']").value = row.cells[0].innerText;
    document.querySelector("#editForm [name='last_name']").value = row.cells[1].innerText;
    document.querySelector("#editForm [name='surname']").value = row.cells[2].innerText;
    document.querySelector("#editForm [name='email_address']").value = row.cells[3].innerText;
    document.querySelector("#editForm [name='status']").value = row.cells[4].innerText;

    // Set the user ID in the hidden input field
    document.querySelector("#editUserId").value = id;

    // Display the Edit People Pop-up Form
    document.getElementById("editForm").style.display = "block";
}


function closeForm2() {
    document.getElementById("editForm").style.display = "none";
  }

</script>


<!--People Table-->         
<div class="table--container">
    <table id="peopleTable" class="searchable-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Surname</th>
                <th>Email Address</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('connect.php');

            // Fetch data from the database
            $result = $conn->query("SELECT * FROM member");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-id='{$row['id']}'>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['surname']}</td>
                            <td>{$row['email_address']}</td>
                            <td>{$row['status']}</td>
                            <td><button onclick='editUser({$row['id']})'
                            style='background-color: #0077b6; color: white; padding: 6px 12px; border: none; 
                            border-radius: 3px; cursor: pointer;'>Edit</button></td>
                         </tr>";               
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
        
    </table>
</div>
</div>  



<!--GROUPS-->
<div class ="tabular--wrapper">
    <h3 class="main--title"> Groups </h3>
        <div class="search--box">
            <i class ="fa fa-search"></i>
            <input type="text" class="searchInput" data-table="groupTable" placeholder="Search Person">
</div> <br>
 
<!--Group popup form -->
<button class="open-button" onclick="openForm3()">Add Group</button>

<div class="form-popup" id="myForm2">
<form action="add_group.php" method="post" class="form-container">
<h1>Add Group</h1>
    <br>

    <label for="Group Name">Group Name</label>
    <input type="text" placeholder="Group Name" name="name" required>

    <label for="status">Status:</label>
    <select id="status" name="status">
    <option value="" disabled selected>Status</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select>

    <button type="submit" class="btn">Add </button>
    <br> <br>
    <button type="button" class="btn" onclick="closeForm3()">Close</button>
  </form>
</div>

<script>
    function openForm3() {
    document.getElementById("myForm2").style.display = "block";
  }
  
  function closeForm3() {
    document.getElementById("myForm2").style.display = "none";
  }
  </script>
  

<!--Edit Groups Pop-up Form-->
<div class="form-popup" id="editform2">

  <form action="edit_group.php" method="post" class="form-container">
    <h1>Edit Group</h1>
    <br>
    <input type="hidden" name="group_id" id="editGroupId" value="">

    <label for="group_name">Group Name</label>
    <input type="text" placeholder="Group Name" name="name" required>

    <label for="status">Status:</label>
    <select name="status">
    <option value="" disabled selected>Status</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select> <br> <br>

    <button type="submit" class="btn">Update </button>
    <br> <br>
    <button type="button" class="btn" onclick="closeForm4()">Cancel</button>
  </form>
  </div>

  <script>
    function editGroup(id) {
        // Fetch the corresponding table row using the unique identifier
        var row = document.querySelector("tr[data-id='" + id + "']");
        
        // Populate the Edit People Pop-up Form fields
        document.querySelector("#editform2 [name='name']").value = row.cells[0].innerText;
        document.querySelector("#editform2 [name='status']").value = row.cells[1].innerText;
    
        // Set the user ID in the hidden input field
        document.querySelector("#editGroupId").value = id;
    
        // Display the Edit People Pop-up Form
        document.getElementById("editform2").style.display = "block";
    }
    
    
    function closeForm4() {
        document.getElementById("editform2").style.display = "none";
      }

    // Add event listener for input change on all search inputs
    $('.searchInput').on('input', function () {
        const query = $(this).val().toLowerCase();
        const tableId = $(this).data('table');
        filterTable(tableId, query);
    });

    // Function to filter the table based on the search query
    function filterTable(tableId, query) {
        $(`#${tableId} tbody tr`).each(function () {
            const rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.includes(query));
        });
    }

    </script>


<!--Group Table-->        
<div class ="table--container">
    <table id="groupTable" class="searchable-table">
        <thead>
            <tr>
                <th>Group Name</th>
                <th>Status</th>    
                <th>Total Members</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('connect.php');

            $result = $conn->query("SELECT church_group.id, church_group.name, church_group.status, 
            COUNT(member_group.group_id) AS total_members
            FROM church_group
            LEFT JOIN member_group ON church_group.id = member_group.group_id
            GROUP BY church_group.id, church_group.name, church_group.status;
            ");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-id='{$row['id']}'>
                    
                            <td>{$row['name']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['total_members']}</td>
                            <td><button onclick='editGroup({$row['id']})'
                            style='background-color: #0077b6; color: white; padding: 6px 12px; border: none; 
                            border-radius: 3px; cursor: pointer;'>Edit</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>


   
</div>

