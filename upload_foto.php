<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Foto Siswa Massal</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        input[type="file"] { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Upload Foto Siswa Massal</h2>
    <p><strong>Catatan:</strong> Pastikan nama file = <code>NISN.jpg</code> (contoh: <code>3219876540.jpg</code>)</p>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fotos[]" accept=".jpg" multiple required><br>
        <button type="submit" name="upload">Upload</button>
    </form>

    <?php
    if (isset($_POST['upload'])) {
        $total = count($_FILES['fotos']['name']);
        $berhasil = 0;
        $gagal = 0;

        for ($i = 0; $i < $total; $i++) {
            $tmp = $_FILES['fotos']['tmp_name'][$i];
            $nama = basename($_FILES['fotos']['name'][$i]);

            // Validasi nama file harus NISN.jpg
            if (preg_match('/^\d{10,}\.jpg$/', $nama)) {
                $tujuan = 'foto/' . $nama;
                if (move_uploaded_file($tmp, $tujuan)) {
                    $berhasil++;
                } else {
                    $gagal++;
                }
            } else {
                $gagal++;
            }
        }

        echo "<p>✅ Berhasil upload: <strong>$berhasil</strong><br>❌ Gagal: <strong>$gagal</strong></p>";
    }
    ?>

    <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
</body>
</html>
