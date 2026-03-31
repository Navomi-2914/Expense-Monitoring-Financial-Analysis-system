<?php
session_start();
include("config.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$sql = "
SELECT 
    u.user_id,
    u.full_name,
    u.email,
    u.role,
    COALESCE(SUM(e.amount),0) AS total_expense,
    COUNT(e.expense_id) AS total_transactions
FROM users u
LEFT JOIN expenses e ON u.user_id = e.user_id
GROUP BY u.user_id
ORDER BY u.user_id DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Registered Users</title>
<style>
body{
    background:#141E30;
    color:white;
    font-family:Segoe UI;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    text-align:center;
}
th{
    background:#ff7e5f;
}
tr:nth-child(even){
    background:#1f2c3d;
}
</style>
</head>
<body>

<h2 style="text-align:center;">All Registered Users</h2>

<table border="1">
<tr>
<th>User ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Total Expense (₹)</th>
<th>Total Transactions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['user_id']; ?></td>
<td><?= $row['full_name']; ?></td>
<td><?= $row['email']; ?></td>
<td><?= $row['role']; ?></td>
<td>₹ <?= number_format($row['total_expense'],2); ?></td>
<td><?= $row['total_transactions']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>