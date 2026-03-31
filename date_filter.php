<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Date Range Analysis</title>
</head>
<body>

<h2>Select Date Range</h2>

<form method="POST" action="date_report.php">
    <label>Start Date:</label>
    <input type="date" name="start_date" required>

    <label>End Date:</label>
    <input type="date" name="end_date" required>

    <button type="submit">Generate Report</button>
</form>

</body>
</html>