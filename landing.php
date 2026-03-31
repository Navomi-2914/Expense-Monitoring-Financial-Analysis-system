<!DOCTYPE html>
<html>
<head>
    <title>Smart Expense Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
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
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                        url('https://images.unsplash.com/photo-1554224155-6726b3ff858f');
            background-size:cover;
            background-position:center;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            text-align:center;
        }

        .container{
            max-width:800px;
            padding:20px;
        }

        h1{
            font-size:48px;
            font-weight:700;
            margin-bottom:20px;
        }

        p{
            font-size:18px;
            margin-bottom:30px;
            color:#ddd;
        }

        .btn{
            display:inline-block;
            padding:12px 30px;
            margin:10px;
            border-radius:30px;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        }

        .btn-primary{
            background:#ff6b35;
            color:white;
        }

        .btn-primary:hover{
            background:#ff3b00;
        }

        .btn-outline{
            border:2px solid white;
            color:white;
        }

        .btn-outline:hover{
            background:white;
            color:black;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>SMART EXPENSE MANAGER</h1>
    <p>Design & Development of a Web-Based Digital Micro-Expense System using MySQL</p>

    <a href="login.php" class="btn btn-primary">Login</a>
    <a href="signup.php" class="btn btn-outline">Sign Up</a>
</div>

</body>
</html>