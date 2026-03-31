<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 🔥 JOIN categories table */
$sql = "
    SELECT e.expense_id,
           e.title,
           c.category_name,
           e.amount,
           e.expense_date
    FROM expenses e
    JOIN categories c ON e.category_id = c.category_id
    WHERE e.user_id = '$user_id'
    ORDER BY e.expense_date DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Expense Records</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#141E30,#243B55);
    color:white;
}

.container{
    width:90%;
    margin:50px auto;
}

h2{
    text-align:center;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(0,0,0,0.6);
    border-radius:10px;
    overflow:hidden;
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

a.btn{
    padding:6px 10px;
    text-decoration:none;
    border-radius:6px;
    font-size:12px;
    color:white;
}

.edit{
    background:#4CAF50;
}

.delete{
    background:#e74c3c;
}

.back{
    display:inline-block;
    margin-top:20px;
    background:#ff7e5f;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
    color:white;
}
</style>
</head>
<body>

<div class="container">
<h2>Expense Records</h2>

<table>
<tr>
<th>ID</th>
<th>Title</th>
<th>Category</th>
<th>Amount (₹)</th>
<th>Date</th>
<th>Edit</th>
<th>Delete</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['expense_id']; ?></td>
<td><?= $row['title']; ?></td>
<td><?= $row['category_name']; ?></td>   <!-- 🔥 FIXED -->
<td><?= $row['amount']; ?></td>
<td><?= $row['expense_date']; ?></td>
<td>
<a class="btn edit" href="edit_expense.php?id=<?= $row['expense_id']; ?>">Edit</a>
</td>
<td>
<a class="btn delete" href="delete_expense.php?id=<?= $row['expense_id']; ?>" 
onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php } ?>

</table>

<a class="back" href="user_dashboard.php">← Back to Dashboard</a>

</div>

</body>
</html>