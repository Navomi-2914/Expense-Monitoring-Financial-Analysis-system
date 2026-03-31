<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$expense_id = $_GET['id'];

/* FETCH EXPENSE */
$sql = "SELECT * FROM expenses WHERE expense_id='$expense_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

/* FETCH CATEGORIES */
$cat_query = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_query);

/* UPDATE EXPENSE */
if(isset($_POST['update'])){
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['expense_date'];
    $category_id = $_POST['category_id'];

    $update_sql = "
        UPDATE expenses 
        SET title='$title',
            amount='$amount',
            expense_date='$date',
            category_id='$category_id'
        WHERE expense_id='$expense_id'
    ";

    mysqli_query($conn, $update_sql);
    header("Location: view_expenses.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Expense</title>
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#141E30,#243B55);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
}

.card{
    background:rgba(0,0,0,0.6);
    padding:30px;
    border-radius:15px;
    width:350px;
}

input,select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
}

button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:#ff7e5f;
    color:white;
    cursor:pointer;
}
</style>
</head>
<body>

<div class="card">
<h2>Edit Expense</h2>

<form method="POST">

<input type="text" name="title" value="<?= $row['title']; ?>" required>

<select name="category_id" required>
<?php while($cat = mysqli_fetch_assoc($cat_result)) { ?>
<option value="<?= $cat['category_id']; ?>"
<?php if($cat['category_id'] == $row['category_id']) echo "selected"; ?>>
<?= $cat['category_name']; ?>
</option>
<?php } ?>
</select>

<input type="number" name="amount" value="<?= $row['amount']; ?>" required>

<input type="date" name="expense_date" value="<?= $row['expense_date']; ?>" required>

<button type="submit" name="update">Update Expense</button>

</form>
</div>

</body>
</html>