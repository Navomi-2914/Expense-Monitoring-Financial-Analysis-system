<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$category_totals = [];
$result = null;

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "
        SELECT e.title, e.amount, e.expense_date, c.category_name
        FROM expenses e
        JOIN categories c ON e.category_id = c.category_id
        WHERE e.user_id = '$user_id'
        AND e.expense_date BETWEEN '$start_date' AND '$end_date'
        ORDER BY e.expense_date DESC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $cat = $row['category_name'];
            $amount = $row['amount'];

            if (isset($category_totals[$cat])) {
                $category_totals[$cat] += $amount;
            } else {
                $category_totals[$cat] = $amount;
            }
        }

        // Run query again for table display
        $result = mysqli_query($conn, $sql);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filtered Expenses</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            padding: 40px;
        }

        h1, h2 {
            text-align: center;
        }

        table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 80%;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #ff7e5f;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .back-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #ff7e5f;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        canvas {
            display: block;
            margin: 40px auto;
            max-width: 500px;
        }

        .no-data {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>

<h1>Filtered Expenses</h1>

<?php if ($result && mysqli_num_rows($result) > 0) { ?>

<table>
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Amount (₹)</th>
        <th>Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['category_name']; ?></td>
            <td>₹ <?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo $row['expense_date']; ?></td>
        </tr>
    <?php } ?>

</table>

<h2>Expense Distribution</h2>
<canvas id="expenseChart"></canvas>

<script>
const ctx = document.getElementById('expenseChart').getContext('2d');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(array_keys($category_totals)); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($category_totals)); ?>,
            backgroundColor: [
                '#ff6384',
                '#36a2eb',
                '#ffce56',
                '#4bc0c0',
                '#9966ff',
                '#ff9f40'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'white',   // ✅ legend text white
                    font: {
                        size: 14
                    }
                }
            }
        }
    }
});
</script>

<?php } else { ?>

<div class="no-data">No expenses found for selected date range.</div>

<?php } ?>

<a href="user_dashboard.php" class="back-btn">Back to Dashboard</a>

</body>
</html>