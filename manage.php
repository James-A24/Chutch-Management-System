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
            <br> <br> <br> 
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
                <h2>Manage </h2>
            </div>
        <div class ="user--info">
            <img src="icons/admin icon.png" style="width:42px;height:42px;">    
        </div>
        </div>

<!--ASSIGNING ROLES AND GROUP-->
<div class="tabular--wrapper">
    <h3 class="main--title">Manage Groups and Roles</h3> 
    <div class="search--box">
        <i class="fa fa-search"></i>
        <input type="text" class="searchInput" data-table="roleTable" placeholder="Search Person" oninput="searchNames()">
    </div>
    <br>

<!--Edit Group,roles Pop-up Form-->
<div class="form-popup" id="editform">

  <form action="edit_role_group.php" method="post" class="form-container">
    <h1>Edit Details</h1>
    <br>
    <input type="hidden" name="member_id" id="member_id" value="">
    <input type="hidden" name="group_id" id="group_id" value="">

    <label for="first_name">First Name</label>
    <input type="text" name="first_name" readonly>

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" readonly>

    <label for="surname">Surname</label>
    <input type="text" name="surname" readonly>
    
    <label for="group_name">Group Name</label>
    <select name="group_name">
    <option value="" disabled selected>Choose Group</option>
      <?php
        include('connect.php');

        $query = "SELECT id, name FROM church_group";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['name']}'>{$row['name']}</option>";
          }
        } else {
          echo "<option value='' disabled selected>No groups found</option>";
        }

        $conn->close();
      ?>
    </select>

    <label for="role">Role:</label>
    <select name="role">
    <option value="" disabled selected>Choose Role</option>
    <option value="Leader">Leader</option>
    <option value="Member">Member</option>
    </select> <br> <br>

    <button type="submit" class="btn">Update </button>
    <br> <br>
    <button type="button" class="btn" onclick="closeForm()">Cancel</button>
  </form>
  </div>

  <script>
  function editrole(member_id, group_id) {
  // Fetch the corresponding table row using the unique identifier
  var row = document.querySelector("tr[data-member-id='" + member_id + "'][data-group-id='" + group_id + "']");
  
  // Populate the Edit People Pop-up Form fields
  document.querySelector("#editform [name='member_id']").value = member_id;
  document.querySelector("#editform [name='group_id']").value = group_id;
  document.querySelector("#editform [name='first_name']").value = row.cells[0].innerText;
  document.querySelector("#editform [name='last_name']").value = row.cells[1].innerText;
  document.querySelector("#editform [name='surname']").value = row.cells[2].innerText;
  document.querySelector("#editform [name='group_name']").value = row.cells[3].innerText;
  document.querySelector("#editform [name='role']").value = row.cells[4].innerText;


 
  // Display the Edit People Pop-up Form
  document.getElementById("editform").style.display = "block";
}


  function closeForm() {
    document.getElementById("editform").style.display = "none";
  }

  function searchNames() {
    var input = document.querySelector(".searchInput").value.toLowerCase(); // Get the search input and convert it to lowercase for case-insensitive search
    var tableRows = document.querySelectorAll(".table--container tbody tr"); // Get all table rows

    tableRows.forEach(function(row) {
        var rowText = row.textContent.toLowerCase(); // Get the text content of the row and convert it to lowercase
        if (rowText.includes(input)) {
            row.style.display = ""; // Display the row if it contains the search input
        } else {
            row.style.display = "none"; // Hide the row if it doesn't match the search input
        }
    });
}

</script>


<!--Table-->
    <div class="table--container">
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Surname</th>
                    <th>Group Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include('connect.php');

                    $query = "SELECT member.id AS member_id, member.first_name, member.last_name, member.surname,
                                    (SELECT DISTINCT church_group.id
                                    FROM church_group
                                    WHERE church_group.id = (SELECT DISTINCT member_group.group_id
                                                            FROM member_group
                                                            WHERE member_group.member_id = member.id)) AS group_id,
                                    (SELECT DISTINCT church_group.name
                                    FROM church_group
                                    WHERE church_group.id = (SELECT DISTINCT member_group.group_id
                                                            FROM member_group
                                                            WHERE member_group.member_id = member.id)) AS group_name,
                                    (SELECT DISTINCT member_group.role
                                    FROM member_group
                                    WHERE member_group.member_id = member.id) AS role
                            FROM member
                            WHERE member.status = 'active'";


                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        echo "<tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-member-id='{$row['member_id']}' data-group-id='{$row['group_id']}'>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['surname']}</td>
                                        <td>{$row['group_name']}</td>
                                        <td>{$row['role']}</td>
                                        <td><button onclick='editrole(\"{$row['member_id']}\", \"{$row['group_id']}\")'
                                        style='background-color: #0077b6; color: white; padding: 6px 12px; border: none; 
                                        border-radius: 3px; cursor: pointer;'>Edit</button></td>
                                        </tr>";
                        }
                        echo "</tbody>";
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>

            </tbody>
        </table>
    </div>
</div>
</html>