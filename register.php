<?php
include 'php/koneksi.php';

// Hanya jalankan logika ini jika form benar-benar sudah dikirim
if (isset($_POST['register'])) {
    // Ambil data dengan aman, tanpa email
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validasi
    $error = null;
    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "Semua field wajib diisi!";
    } elseif (strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "Password harus mengandung setidaknya satu huruf besar!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "Password harus mengandung setidaknya satu angka!";
    } elseif ($password !== $confirm) {
        $error = "Konfirmasi password tidak sesuai!";
    }

    // Jika tidak ada error, lanjutkan proses ke database
    if (!$error) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $cek = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $res = $cek->get_result();

        if ($res->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Hanya masukkan username dan password yang sudah di-hash
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password_hash);
            
            if ($stmt->execute()) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $error = "Registrasi gagal, silakan coba lagi!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./img/newicon.png" type="image/x-icon">
    <style>
        body {
            background-color: #2d3436;
            background-image: linear-gradient(315deg, #2d3436 0%, #000000 74%);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #bdc3c7;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #5c2c2c; /* Warna background error */
            color: #f2a6a6; /* Warna teks error */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #7c3f3f;
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

        .btn-register {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            border-radius: 8px;
            border: none;
            background: none; /* Hapus background */
            color: #fff; /* Pink, agar sesuai tema */
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-sizing: border-box;
            transition: color 0.2s ease;
        }
        
        .btn-register:hover {
            color: #eaeaea;
        }

        .login-link {
            margin-top: 40px;
            font-size: 14px;
        }

        .login-link a {
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create Account</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <button type="submit" name="register" class="btn-register">REGISTER</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">LOG IN</a>
        </div>
    </div>
</body>
</html>