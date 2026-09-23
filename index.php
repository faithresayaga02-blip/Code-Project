<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 380px;
            box-sizing: border-box;
        }

        .container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 18px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="pakicheck.php" method="POST">
            <input type="text" name="username" placeholder="Enter your username" required autofocus>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>