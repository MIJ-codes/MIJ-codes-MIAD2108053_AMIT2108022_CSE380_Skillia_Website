<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, password FROM admins WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    // Debug output
    echo '<pre>'; print_r($admin); echo '</pre>';
    echo 'Username entered: ' . htmlspecialchars($username) . '<br>';
    echo 'Password entered: ' . htmlspecialchars($password) . '<br>';
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: admin-dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Skillia</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff 0%, #ffb6c1 60%, #ff8fa3 100%);
            position: relative;
            overflow: hidden;
        }
        .login-container {
            max-width: 370px;
            margin: 40px auto;
            background: linear-gradient(120deg, rgba(179,18,23,0.97) 80%, rgba(255,255,255,0.13) 100%);
            box-shadow: 0 0 32px 0 rgba(255,255,255,0.7), 0 2px 12px 0 rgba(179,18,23,0.10);
            border: 1.5px solid rgba(255,255,255,0.45);
            position: relative;
            padding: 64px 44px 48px 44px;
            border-radius: 32px;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 18%;
            border-radius: 32px 32px 120px 120px/32px 32px 80px 80px;
            background: linear-gradient(120deg, rgba(255,255,255,0.38) 0%, rgba(255,255,255,0.08) 100%);
            opacity: 0.65;
            pointer-events: none;
            z-index: 2;
            filter: blur(1.5px);
        }
        .login-container::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 32px;
            box-shadow: 0 0 32px 12px rgba(255,255,255,0.08) inset, 0 2px 24px 0 rgba(60,0,0,0.08) inset;
            pointer-events: none;
            z-index: 2;
        }
        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 18px;
        }
        .login-logo span {
            display: inline-block;
            background: #fff;
            color: #b31217;
            font-size: 2.2rem;
            border-radius: 50%;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(220,38,38,0.13);
        }
        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px rgba(80,0,80,0.13);
        }
        .form-group {
            margin-bottom: 18px;
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #fff;
            letter-spacing: 0.5px;
            width: 100%;
            text-align: left;
        }
        .input-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            background: linear-gradient(120deg, #fff 60%, #f3e6e6 100%);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(179,18,23,0.07), 0 0.5px 2px rgba(179,18,23,0.04), 0 2px 8px 0 rgba(179,18,23,0.10);
            border: none;
            margin-bottom: 8px;
            transition: box-shadow 0.2s, background 0.2s;
            box-shadow: 0 2px 8px rgba(179,18,23,0.07), 0 0.5px 2px rgba(179,18,23,0.04), 0 2px 8px 0 rgba(179,18,23,0.10),
                0 1.5px 8px 0 rgba(255,255,255,0.18) inset, 0 2px 8px 0 rgba(0,0,0,0.08) inset;
        }
        .input-wrapper:focus-within {
            box-shadow: 0 0 0 2px #b31217, 0 2px 8px rgba(179,18,23,0.07), 0 0.5px 2px rgba(179,18,23,0.04),
                0 1.5px 8px 0 rgba(255,255,255,0.18) inset, 0 2px 8px 0 rgba(0,0,0,0.10) inset;
            background: linear-gradient(120deg, #fff 60%, #f3e6e6 100%);
        }
        .input-icon {
            margin-left: 16px;
            margin-right: 8px;
            color: #b31217;
            font-size: 1.25rem;
            opacity: 0.85;
            pointer-events: none;
            display: flex;
            align-items: center;
            filter: drop-shadow(0 1px 1px rgba(0,0,0,0.10));
        }
        input[type="text"], input[type="password"] {
            flex: 1 1 auto;
            width: 100%;
            padding: 13px 14px 13px 0;
            border: none;
            border-radius: 10px;
            background: transparent;
            font-family: 'Times New Roman', Times, serif;
            font-size: 1.15rem;
            color: #7b0a19;
            transition: background 0.2s;
            font-weight: 600;
            letter-spacing: 0.01em;
            box-shadow: 0 1.5px 8px 0 rgba(255,255,255,0.10) inset, 0 2px 8px 0 rgba(0,0,0,0.06) inset;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            background: rgba(255,255,255,0.85);
            color: #3a0307;
        }
        ::placeholder {
            color: #b31217;
            opacity: 0.7;
        }
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(90deg, #ff1744 0%, #b31217 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
            box-shadow: 0 2px 16px rgba(255,23,68,0.13);
            transition: background 0.2s, transform 0.1s;
        }
        button:hover {
            background: linear-gradient(90deg, #b31217 0%, #ff1744 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .error {
            color: #b31217;
            text-align: center;
            margin-bottom: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .show-password-row {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 6px;
            width: 100%;
        }
        .forgot-row {
            margin-top: 6px;
            margin-bottom: 10px;
            text-align: right;
            width: 100%;
        }
        .forgot-row a {
            color: #fff;
            font-size: 14px;
            text-decoration: underline;
            opacity: 0.85;
            transition: color 0.2s;
        }
        .forgot-row a:hover {
            color: #b31217;
        }
        .register-row {
            margin-top: 18px;
            text-align: center;
            color: #fff;
            font-size: 15px;
            width: 100%;
        }
        .register-row a {
            color: #fff;
            font-weight: 600;
            text-decoration: underline;
            margin-left: 4px;
            opacity: 0.85;
        }
        .register-row a:hover {
            color: #b31217;
        }
        @media (max-width: 500px) {
            .login-container { padding: 18px 6vw; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo"><span>🔒</span></div>
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#128100;</span>
                    <input type="text" id="username" name="username" required autofocus placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#128274;</span>
                    <input type="password" id="password" name="password" required placeholder="Password">
                </div>
                <div class="show-password-row">
                    <input type="checkbox" id="show-password" onclick="togglePassword()">
                    <label for="show-password" style="font-size: 14px; cursor:pointer; color:#fff;">Show Password</label>
                </div>
            </div>
            <div class="forgot-row"><a href="#">Forgot Password?</a></div>
            <button type="submit">Login</button>
            <div class="register-row">Don't have an account? <a href="#">Register</a></div>
        </form>
    </div>
    <script>
        function togglePassword() {
            var pwd = document.getElementById('password');
            pwd.type = pwd.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html> 