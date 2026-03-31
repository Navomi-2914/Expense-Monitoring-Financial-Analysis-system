<?php  
include "config.php";  

$message = "";

if(isset($_POST['register'])){  
    $name = $_POST['name'];  
    $email = $_POST['email'];  
    $password = $_POST['password'];  

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");  

    if(mysqli_num_rows($check) > 0){  
        $message = "Email already exists!";
    } else {  
        mysqli_query($conn,"  
            INSERT INTO users (name,email,password,role)  
            VALUES ('$name','$email','$password','user')  
        ");  
        $message = "Registration successful!";
    }  
}  
?>  

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Card */
.card {
    background: rgba(255,255,255,0.1);
    padding: 40px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    width: 350px;
    color: white;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Inputs */
input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    outline: none;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 25px;
    background: #ff7e5f;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #feb47b;
}

/* Message */
.message {
    text-align: center;
    margin-bottom: 10px;
    font-size: 14px;
    color: #ffdede;
}

/* Link */
a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #ddd;
    text-decoration: none;
}
</style>

</head>

<body>

<div class="card">
    <h2>Register</h2>

    <?php if($message != "") { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">  
        <input type="text" name="name" placeholder="Enter Name" required>  
        <input type="email" name="email" placeholder="Enter Email" required>  
        <input type="password" name="password" placeholder="Enter Password" required>  
        <button type="submit" name="register">Register</button>  
    </form>

    <a href="login.php">Already have an account? Login</a>
</div>

</body>
</html>