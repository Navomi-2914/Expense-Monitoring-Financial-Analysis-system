<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

/* Admin sees full report */
/* User sees only own report */

if($role == 'admin') {
    $query = "SELECT * FROM expense_report_view ORDER BY expense_date DESC";
} else {
    $query = "SELECT * FROM expense_report_view 
              WHERE user_id = '$user_id'
              ORDER BY expense_date DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Expense Reports</title>

<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    color: white;
}

.container {
    width: 95%;
    margin: 40px auto;
}

.card {
    background: rgba(255,255,255,0.1);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: rgba(255,255,255,0.2);
}

tr:nth-child(even) {
    background: rgba(255,255,255,0.05);
}

.btn {
    display: inline-block;
    padding: 8px 15px;
    margin-top: 15px;
    border-radius: 25px;
    text-decoration: none;
    color: white;
    background: #ff7e5f;
    transition: 0.3s;
}

.btn:hover {
    background: #feb47b;
}
</style>

</head>
<body>

<div class="container">
<div class="card">

<h2>Expense Reports 📊</h2>

<?php if($role == 'admin') { ?>
<a href="admin_dashboard.php" class="btn">⬅ Back to Dashboard</a>
<?php } else { ?>
<a href="user_dashboard.php" class="btn">⬅ Back to Dashboard</a>
<?php } ?>

<table>
<tr>
    <th>User</th>
    <th>Email</th>
    <th>Title</th>
    <th>Category</th>
    <th>Amount (₹)</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td>₹ <?php echo number_format($row['amount'],2); ?></td>
    <td><?php echo $row['expense_date']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>