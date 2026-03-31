<?php
session_start();
include("config.php");

if(isset($_POST['login'])){
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple static admin login (for project demo)
    if($username == "admin" && $password == "admin123"){
        
        $_SESSION['admin_id'] = 1;
        header("Location: admin_dashboard.php");
        exit();
    }
    else{
        $error = "Invalid Admin Credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

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
    width:350px;
    border-radius:15px;
    box-shadow:0 10px 40px rgba(0,0,0,0.8);
    color:white;
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
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
}

button:hover{
    background:#feb47b;
}

.error{
    color:red;
    margin-bottom:10px;
}
</style>

</head>
<body>

<div class="card">
<h2>Admin Login</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

</div>

</body>
</html>