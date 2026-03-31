<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    padding:40px;
    width:350px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
    color:white;
}

h2{
    text-align:center;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
    background:rgba(255,255,255,0.15);
    color:white;
}

input::placeholder{
    color:#ddd;
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
    color:#ddd;
    text-decoration:none;
    display:block;
    margin-top:5px;
}
</style>
</head>
<body>

<div class="card">
<h2>Admin - Add User</h2>

<form method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="add_user">Add User</button>
</form>

<div class="links">
<a href="add_expense.php">Add Expense</a>
<a href="view_expenses.php">View All Expenses</a>
<a href="reports.php">View Reports</a>
<a href="index.php">Back to Dashboard</a>
</div>

</div>

</body>
</html>