<?php
session_start();


$valid_username = "riya";
$valid_password = "12345";

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();


    setcookie("username", "", time() - 3600, "/");
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}


$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;

       
        if (isset($_POST['remember'])) {
            setcookie("username", $username, time() + (86400 * 7), "/");
        }

        header("Location: login.php");
        exit();
    } else {
        $error = "❌ Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ffe4e1, #cce7ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            width: 340px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95);}
            to { opacity: 1; transform: scale(1);}
        }
        h2 {
            margin-bottom: 20px;
            color: #ff7f9e;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ffd1dc;
            border-radius: 10px;
            outline: none;
            transition: 0.3s;
            background: #fff8f8;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #a3d2ff;
            box-shadow: 0 0 6px rgba(163,210,255,0.5);
        }
        input[type="checkbox"] {
            margin-right: 6px;
        }
        .btn {
            background: #a3d2ff;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #7bbfff;
            transform: scale(1.02);
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .logout {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            background: #ff7f9e;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .logout:hover {
            background: #ff4c70;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['username'])): ?>
            <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> 🎉</h2>
            <a class="logout" href="login.php?logout=true">Logout</a>
        <?php else: ?>
            <h2>Login</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <label><input type="checkbox" name="remember"> Remember me</label><br>
                <button type="submit" class="btn" name="login">Login</button>
                <?php if (!empty($error)): ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

