<?php
// File: index.php (Login Page)
session_start();
include 'db.php';

// Ambil data pengaturan
$pengaturan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengaturan LIMIT 1"));
$logo_path = 'assets/logo/' . $pengaturan['logo'];

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password=MD5('$password')");
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['login'] = true;
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id'];
        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: siswa.php");
        }
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Kartu Pelajar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary: #003366;
            --light: #f9f9f9;
            --danger: #cc0000;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--light);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 1rem;
        }

        h2 {
            margin-top: 0.5rem;
            color: var(--primary);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        button {
            padding: 0.75rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #002244;
        }

        .error {
            color: var(--danger);
            text-align: center;
            margin-bottom: 1rem;
        }

        .note {
            text-align: center;
            font-size: 0.9rem;
            color: #555;
            margin-top: 1rem;
        }

        footer {
            background-color: #111;
            color: #ccc;
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
        }

        footer a {
            color: #00c3ff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 1.5rem;
            }
            header {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Aplikasi Kartu Pelajar</h1>
</header>

<main>
    <div class="login-container">
        <?php if (file_exists($logo_path)) : ?>
            <img src="<?= $logo_path ?>" alt="Logo Sekolah" class="logo">
        <?php endif; ?>
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p class="note"><em>Aplikasi masih dalam proses pengembangan</em></p>
        <p class="note"><em>Siswa dapat melakukan perbaikan data dan upload foto login username: NISN, pasword: NISN</em></p>
    </div>
</main>

<footer>
    &copy; 2025 - Dibuat oleh <a href="https://www.youtube.com/@nirsinggih" target="_blank">Nir Singgih</a><br>
    Versi awal, masih dalam pengembangan.
</footer>

</body>
</html>
