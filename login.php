<?php
session_start();
include("config.php");

$error = "";

if(isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['full_name'];
        $_SESSION['role'] = $row['role'];

        if($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: user_dashboard.php");
            exit();
        }

    } else {
        $error = "Invalid Login Details!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Expense Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                        url('https://images.unsplash.com/photo-1492724441997-5dc865305da7');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            color: white;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }

        .login-box h2 {
            margin-bottom: 25px;
            font-weight: 600;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #ff7a45;
            border: none;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            background: #ff5722;
        }

        .back-link {
            margin-top: 15px;
            display: block;
            color: #ddd;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            color: #fff;
        }

        .error {
            color: #ff4d4d;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>

    <form class="login-box" method="POST">

        <h2>Smart Expense Login</h2>

        <?php if(!empty($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="login">Login</button>

        <a href="index.php" class="back-link">← Back to Home</a>
        <a href="register.php">New User? Register Here</a>

    </form>

</body>
</html>