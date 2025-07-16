<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #2d3436; /* Warna background gelap */
            background-image: linear-gradient(315deg, #2d3436 0%, #000000 74%);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #bdc3c7; /* Warna teks default */
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-sizing: border-box;
            transition: opacity 0.3s ease;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-facebook {
            background-color: #3b5998;
        }

        .btn-twitter {
            background-color: #1da1f2;
        }

        .separator {
            color: #7f8c8d;
            margin: 30px 0;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            background-color: #3b4144;
            border: 1px solid #4a5154;
            border-radius: 8px;
            padding: 15px;
            box-sizing: border-box;
            color: #ffffff;
            font-size: 16px;
        }

        .form-control::placeholder {
            color: #7f8c8d;
        }

        .form-control:focus {
            outline: none;
            border-color: #1da1f2;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
        }

        .btn-login {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            padding: 15px 0;
            width: auto;
            margin-top: 10px;
        }

        .signup-link {
            margin-top: 40px;
            font-size: 14px;
        }

        .signup-link a {
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <p class="separator">Login with username</p>

        <form method="POST" action="php/auth.php">
            <div class="input-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <span class="password-toggle" onclick="togglePasswordVisibility()">👁️</span>
            </div>
            <button type="submit" name="login" class="btn-login">LOGIN</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="register.php">SIGN UP NOW</a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈'; // Ganti ikon jika perlu
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>