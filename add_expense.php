<?php
session_start();
include "config.php";

// Allow only user role
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Insert Expense
if(isset($_POST['add_expense'])){

    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];

    $sql = "INSERT INTO expenses 
            (user_id, title, category_id, amount, expense_date)
            VALUES 
            ('$user_id', '$title', '$category_id', '$amount', '$expense_date')";

    if($conn->query($sql)){
        header("Location: view_expenses.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Expense</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#141E30,#243B55);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    background: rgba(0,0,0,0.7);
    padding:40px;
    width:400px;
    border-radius:15px;
    box-shadow:0 10px 40px rgba(0,0,0,0.8);
    color:white;
}

h2{
    text-align:center;
    margin-bottom:25px;
}

input, select{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
    background:#f4f4f4;
    color:#333;
    font-size:14px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#ff7e5f;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#feb47b;
}

.links{
    text-align:center;
    margin-top:20px;
}

.links a{
    color:#ccc;
    text-decoration:none;
    display:block;
    margin-top:5px;
}
</style>

</head>
<body>

<div class="card">
<h2>Add Expense</h2>

<form method="POST">

<select name="category_id" required>
<option value="">Select Category</option>
<?php while($row = $categories->fetch_assoc()){ ?>
<option value="<?= $row['category_id']; ?>">
<?= $row['category_name']; ?>
</option>
<?php } ?>
</select>

<input type="text" name="title" placeholder="Expense Title" required>

<input type="number" step="0.01" name="amount" placeholder="Amount" required>

<input type="date" name="expense_date" required>

<button type="submit" name="add_expense">Add Expense</button>

</form>

<div class="links">
<a href="view_expenses.php">View Expenses</a>
<a href="reports.php">View Reports</a>
<a href="user_dashboard.php">Back to Dashboard</a>
</div>

</div>

</body>
</html>