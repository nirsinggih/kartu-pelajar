<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require 'db.php';

// Ambil daftar kelas unik dari tabel siswa
$kelas = [];
$result = mysqli_query($conn, "SELECT DISTINCT kelas FROM siswa ORDER BY kelas ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $kelas[] = $row['kelas'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas untuk Cetak Kartu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 480px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #2d4373; /* Biru tua */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #1d2d50;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #2d4373;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cetak Kartu Pelajar</h2>

        <form method="GET" action="cetak_kartu.php" target="_blank">
            <label for="kelas">Pilih Kelas:</label>
            <select name="kelas" id="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?php echo htmlspecialchars($k); ?>"><?php echo htmlspecialchars($k); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Cetak Kartu</button>
        </form>

        <a href="dashboard.php">← Kembali ke Dashboard</a>
    </div>
</body>
</html>
