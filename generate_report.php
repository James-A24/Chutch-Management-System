<?php
include('connect.php');

// Create an array to store the report data
$reportData = array();

// Fetch total members count
$sql = "SELECT COUNT(*) as totalMembers FROM member";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $reportData['Total Members'] = $row['totalMembers'];
}

// Fetch active members count
$sql = "SELECT COUNT(*) as activeMembers FROM member WHERE status = 'Active'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $reportData['Active Members'] = $row['activeMembers'];
}

// Fetch income data from the database
$incomeResult = $conn->query("SELECT * FROM income");

// Fetch expense data from the database
$expenseResult = $conn->query("SELECT * FROM expense");

// Fetch groups count
$sql = "SELECT COUNT(*) as groups FROM church_group WHERE status = 'Active'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $reportData['Groups'] = $row['groups'];
}

// Initialize total variables
$totalIncome = 0;
$totalExpense = 0;

// Process income data
if ($incomeResult->num_rows > 0) {
    while ($row = $incomeResult->fetch_assoc()) {
        $totalIncome += $row['total'];
        $reportData['Income'][] = [
            'Income Source' => $row['income_source'],
            'Income Type' => $row['income_type'],
            'Date' => $row['date'],
            'Total Contribution/Amount' => $row['total'],
        ];
    }
}

// Process expense data
if ($expenseResult->num_rows > 0) {
    while ($row = $expenseResult->fetch_assoc()) {
        $totalExpense += $row['cost_budget'];
        $reportData['Expenses'][] = [
            'Expense Type' => $row['expense_type'],
            'Description' => $row['description'],
            'Date' => $row['date'],
            'Cost/Budget' => $row['cost_budget'],
        ];
    }
}

$conn->close();

// Now, generate the HTML report
ob_start(); // Start output buffering

echo '<html>';
echo '<head>';
echo '<title>Full Church Report</title>';
echo '<style>';
echo 'body { font-family: Arial, sans-serif; background-color: #f5f5f5; }';
echo '.report { width: 80%; margin: 0 auto; background-color: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }';
echo '.report h1 { font-size: 24px; color: #333; text-align: center; margin-bottom: 20px; }';
echo '.report-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }';
echo '.report-table th, .report-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }';
echo '.report-table th { background-color: #f5f5f5; }';
echo '.total-box { text-align: right; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<div class="report">';
echo '<h1>Full Report</h1>';


// Total Members
echo '<h3>Total Members: ' . $reportData['Total Members'] . '</h3>';

// Active Members
echo '<h3>Active Members: ' . $reportData['Active Members'] . '</h3>';

//Active Groups
echo '<h3>Active Groups: ' . $reportData['Groups'] . '</h3>';

// Income Table
echo '<h2>Income</h2>';
echo '<table class="report-table">';
echo '<tr><th>Income Source</th><th>Income Type</th><th>Date</th><th>Total Contribution/Amount</th></tr>';
foreach ($reportData['Income'] as $income) {
    echo '<tr>';
    echo '<td>' . $income['Income Source'] . '</td>';
    echo '<td>' . $income['Income Type'] . '</td>';
    echo '<td>' . $income['Date'] . '</td>';
    echo '<td>' . $income['Total Contribution/Amount'] . '</td>';
    echo '</tr>';
}
echo '</table>';

// Expenses Table
echo '<h2>Expenses</h2>';
echo '<table class="report-table">';
echo '<tr><th>Expense Type</th><th>Description</th><th>Date</th><th>Cost/Budget</th></tr>';
foreach ($reportData['Expenses'] as $expense) {
    echo '<tr>';
    echo '<td>' . $expense['Expense Type'] . '</td>';
    echo '<td>' . $expense['Description'] . '</td>';
    echo '<td>' . $expense['Date'] . '</td>';
    echo '<td>' . $expense['Cost/Budget'] . '</td>';
    echo '</tr>';
}
echo '</table>';

// Total Income and Expense
echo '<div class="total-box">';
echo '<strong>Total Income: ' . $totalIncome . '</strong><br>';
echo '<strong>Total Expense: ' . $totalExpense . '</strong>';
echo '</div>';

echo '</div>';
echo '</body>';
echo '</html>';

$reportContent = ob_get_clean();

echo $reportContent;
?>