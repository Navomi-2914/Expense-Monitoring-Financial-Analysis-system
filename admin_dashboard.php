<?php
session_start();
include("config.php");

/* ✅ Allow only admin */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* =========================
   SYSTEM OVERVIEW
========================= */

// Total Users
$user_query = mysqli_query($conn,"SELECT COUNT(*) as total_users FROM users");
$user_data = mysqli_fetch_assoc($user_query);
$total_users = $user_data['total_users'] ?? 0;

// Total Transactions
$transaction_query = mysqli_query($conn,"SELECT COUNT(*) as total_transactions FROM expenses");
$transaction_data = mysqli_fetch_assoc($transaction_query);
$total_transactions = $transaction_data['total_transactions'] ?? 0;

// Total System Expense
$expense_query = mysqli_query($conn,"SELECT SUM(amount) as total_expense FROM expenses");
$expense_data = mysqli_fetch_assoc($expense_query);
$total_expense = $expense_data['total_expense'] ?? 0;

if(!$total_expense){
    $total_expense = 0;
}

/* =========================
   FIXED PIE CHART QUERY
========================= */

$chart_query = "
SELECT c.category_name, IFNULL(SUM(e.amount),0) as total
FROM categories c
LEFT JOIN expenses e ON c.category_id = e.category_id
GROUP BY c.category_id
";

$chart_result = mysqli_query($conn,$chart_query);

$categories = [];
$amounts = [];

while($row = mysqli_fetch_assoc($chart_result)){
    $categories[] = $row['category_name'];
    $amounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#141E30,#243B55);
    color:white;
    min-height:100vh;
}

.container{
    width:90%;
    margin:40px auto;
}

h2{
    text-align:center;
}

.cards{
    display:flex;
    gap:20px;
    margin:30px 0;
    flex-wrap:wrap;
}

.card{
    flex:1;
    min-width:250px;
    padding:25px;
    border-radius:15px;
    text-align:center;
    background:rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
}

.btn-container{
    text-align:center;
    margin-bottom:30px;
}

.btn{
    padding:10px 20px;
    margin:5px;
    border:none;
    border-radius:25px;
    cursor:pointer;
    background:#ff7e5f;
    color:white;
    text-decoration:none;
    display:inline-block;
}

.btn:hover{
    background:#feb47b;
}

.chart-box{
    background:rgba(255,255,255,0.1);
    padding:20px;
    border-radius:15px;
}

.chart-container{
    height:400px;
}

canvas{
    background:white;
    border-radius:10px;
    padding:10px;
}
</style>

</head>
<body>

<div class="container">

<h2>👑 Admin Dashboard</h2>

<div class="btn-container">
    <a href="view_users.php" class="btn">View All Users</a>
    <a href="view_all_expenses.php" class="btn">View All Expenses</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="cards">

    <div class="card">
        <h3>Total Users</h3>
        <h2><?php echo $total_users; ?></h2>
    </div>

    <div class="card">
        <h3>Total Transactions</h3>
        <h2><?php echo $total_transactions; ?></h2>
    </div>

    <div class="card">
        <h3>Total System Expense</h3>
        <h2>₹ <?php echo number_format($total_expense,2); ?></h2>
    </div>

</div>

<div class="chart-box">
    <h3 style="text-align:center;">Category Wise Expense Distribution</h3>
    <div class="chart-container">
        <canvas id="adminChart"></canvas>
    </div>
</div>

</div>

<script>
const ctx = document.getElementById('adminChart');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($categories); ?>,
        datasets: [{
            data: <?php echo json_encode($amounts); ?>,
            backgroundColor: [
                '#ff7e5f',
                '#feb47b',
                '#6a11cb',
                '#2575fc',
                '#00c9ff',
                '#92fe9d',
                '#ff9966'
            ]
        }]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                position:'right'
            }
        }
    }
});
</script>

</body>
</html>