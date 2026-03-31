<?php
session_start();
include("config.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* ✅ FIXED QUERY */
$sql = "
SELECT 
    e.expense_id,
    u.full_name,
    e.title,
    c.category_name,
    e.amount,
    e.expense_date
FROM expenses e
LEFT JOIN users u ON e.user_id = u.user_id
LEFT JOIN categories c ON e.category_id = c.category_id
ORDER BY e.expense_date DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Expenses</title>
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#141E30,#243B55);
    color:white;
}

.container{
    width:95%;
    margin:40px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(0,0,0,0.6);
}

th,td{
    padding:12px;
    text-align:center;
}

th{
    background:#ff7e5f;
}

tr:nth-child(even){
    background:rgba(255,255,255,0.05);
}

.back{
    display:inline-block;
    margin-bottom:20px;
    background:#ff7e5f;
    padding:8px 15px;
    border-radius:8px;
    text-decoration:none;
    color:white;
}
</style>
</head>
<body>

<div class="container">
<h2>All Expense Records</h2>

<a class="back" href="admin_dashboard.php">← Back to Dashboard</a>

<table>
<tr>
<th>ID</th>
<th>User</th>
<th>Title</th>
<th>Category</th>
<th>Amount (₹)</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['expense_id']; ?></td>
<td><?= $row['full_name']; ?></td>
<td><?= $row['title']; ?></td>
<td><?= $row['category_name']; ?></td>
<td>₹ <?= number_format($row['amount'],2); ?></td>
<td><?= $row['expense_date']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>