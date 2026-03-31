<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Smart Expense Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
align-items:center;
justify-content:center;
text-align:center;
color:white;

background:linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
url('https://images.unsplash.com/photo-1554224155-6726b3ff858f');

background-size:cover;
background-position:center;
}

.container{
max-width:800px;
padding:20px;
}

h1{
font-size:52px;
margin-bottom:20px;
}

p{
font-size:18px;
margin-bottom:40px;
opacity:0.9;
}

.btn{
display:inline-block;
padding:14px 30px;
margin:10px;
border-radius:30px;
text-decoration:none;
font-weight:600;
transition:0.3s;
}

.user{
background:#ff6b35;
color:white;
}

.admin{
background:white;
color:#333;
}

.btn:hover{
transform:scale(1.05);
}
</style>
</head>

<body>

<div class="container">
<h1>SMART EXPENSE MANAGER</h1>

<p>
Design and Development of Web-Based Digital Micro-Expense Management
Using MySQL Database System
</p>

<a href="login.php" class="btn user">User Login</a>
<a href="admin_login.php" class="btn admin">Admin Login</a>

</div>

</body>
</html>