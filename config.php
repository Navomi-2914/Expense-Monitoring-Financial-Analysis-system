<?php
$conn = new mysqli("localhost", "root", "", "micro_expense_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>