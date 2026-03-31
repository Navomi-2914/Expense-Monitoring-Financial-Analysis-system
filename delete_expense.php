<?php
session_start();
include("config.php");

$id = $_GET['id'];

$sql = "DELETE FROM expenses WHERE expense_id='$id'";
mysqli_query($conn,$sql);

header("Location: view_expenses.php");
?>