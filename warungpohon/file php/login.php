<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* Hilangkan seluruh margin/padding bawaan */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body { 
            background-image: url('backkground2.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 400px;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: black;
            color: white;
            margin-top : 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
        background: #c0392b;
        }
        .back-btn {
        display: block;
        width: 320px;
        margin-top : 10px;
        padding: 10px ;
        background: #000000ff;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }

        .back-btn:hover {
        background: #c0392b;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>
    <form action="login_proses.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">LOGIN</button>
        
    </form>
    <a href="/warungpohon/" class="back-btn">KEMBALI</a>
</div>


</body>
</html>
