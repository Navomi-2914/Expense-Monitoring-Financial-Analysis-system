<?php
session_start();
include "config.php";   // use your existing database connection file

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$start = $_POST['start_date'];
$end   = $_POST['end_date'];

$query = "
SELECT e.expense_id, e.title, c.category_name, e.amount, e.expense_date
FROM expenses e
JOIN categories c ON e.category_id = c.category_id
WHERE e.user_id = '$user_id'
AND e.expense_date BETWEEN '$start' AND '$end'
ORDER BY e.expense_date DESC
";

$result = mysqli_query($conn, $query);
?>

<h2>Filtered Expenses</h2>

<table border="1">
<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Amount</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['category_name']; ?></td>
    <td><?php echo $row['amount']; ?></td>
    <td><?php echo $row['expense_date']; ?></td>
</tr>
<?php } ?>

</table>