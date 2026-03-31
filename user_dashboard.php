<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

/* 🔥 GET SUMMARY DATA (Trigger Table) */
$summary_query = "SELECT * FROM user_expense_summary WHERE user_id = '$user_id'";
$summary_result = mysqli_query($conn, $summary_query);

$total_expense = 0;
$total_transactions = 0;

if(mysqli_num_rows($summary_result) > 0) {
    $row = mysqli_fetch_assoc($summary_result);
    $total_expense = $row['total_expense'];
    $total_transactions = $row['total_transactions'];
}

$average_expense = 0;
if($total_transactions > 0) {
    $average_expense = $total_expense / $total_transactions;
}

/* 🔥 CATEGORY DATA FOR PIE CHART */
$category_query = "
    SELECT c.category_name, SUM(e.amount) as total
    FROM expenses e
    JOIN categories c ON e.category_id = c.category_id
    WHERE e.user_id = '$user_id'
    GROUP BY c.category_name
";

$category_result = mysqli_query($conn, $category_query);

$categories = [];
$amounts = [];

while($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row['category_name'];
    $amounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    color: white;
}

.container {
    width: 90%;
    margin: 40px auto;
}

.card {
    background: rgba(255,255,255,0.1);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    margin-bottom: 25px;
}
.chart-container {
    width: 350px;
    height: 350px;
    margin: auto;
    padding: 20px;
    border-radius: 15px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}
h2 {
    margin-bottom: 15px;
}

.stats {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.stat-box {
    flex: 1;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    background: rgba(255,255,255,0.15);
}

.stat-box h3 {
    margin: 10px 0;
}

.btn {
    display: inline-block;
    padding: 10px 18px;
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

canvas {
    background: white;
    border-radius: 10px;
    padding: 10px;
}
</style>

</head>
<body>

<div class="container">

<div class="card">
    <h2>Welcome, <?php echo $name; ?> 👋</h2>
   <a href="add_expense.php" class="btn">Add Expense</a>
<a href="view_expenses.php" class="btn">View Expenses</a>
<a href="select_date.php" class="btn">Analyze By Date</a>
<a href="logout.php" class="btn">Logout</a>
</div>

<div class="card">
    <h2>Spending Analysis</h2>

    <div class="stats">

        <div class="stat-box">
            <h3>Total Expense</h3>
            <p>₹ <?php echo number_format($total_expense,2); ?></p>
        </div>

        <div class="stat-box">
            <h3>Total Transactions</h3>
            <p><?php echo $total_transactions; ?></p>
        </div>

        <div class="stat-box">
            <h3>Average Expense</h3>
            <p>₹ <?php echo number_format($average_expense,2); ?></p>
        </div>

    </div>
</div>

<div class="card">
    <h2>Category-wise Expense Distribution</h2>
    <div class="chart-container">
    <canvas id="expenseChart"></canvas>
</div>
</div>

</div>

<script>
const ctx = document.getElementById('expenseChart');

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
                '#92fe9d'
            ]
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false
}
});
</script>

</body>
</html>