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
<title>Select Date Range</title>
<style>
body{
    font-family:Segoe UI;
    background:linear-gradient(135deg,#141E30,#243B55);
    color:white;
    text-align:center;
    padding-top:100px;
}
input{
    padding:10px;
    margin:10px;
}
button{
    padding:10px 20px;
    background:#ff7e5f;
    border:none;
    color:white;
    border-radius:5px;
}
</style>
</head>
<body>

<h2>Select Date Range</h2>

<form method="POST" action="filter_expenses.php">
    From: <input type="date" name="start_date" required><br>
    To: <input type="date" name="end_date" required><br>
    <button type="submit">Analyze</button>
</form>

</body>
</html>