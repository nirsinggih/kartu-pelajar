<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

include 'db.php';

$sekolah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengaturan WHERE id = 1"));

if (isset($_POST['simpan'])) {
    $nama    = $_POST['nama_sekolah'];
    $alamat  = $_POST['alamat'];
    $kepala  = $_POST['kepala_sekolah'];
	$nip_kepala  = $_POST['nip_kepala_sekolah'];
    $tanggal = $_POST['tanggal_ttd'];

    $logo = $sekolah['logo'];
    $ttd  = $sekolah['tanda_tangan'];
    $bg   = $sekolah['background'];
    $bg2  = $sekolah['background_belakang'];

    if (!empty($_FILES['logo']['name'])) {
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'png') {
            echo "<script>alert('Logo harus dalam format PNG');location.href='edit_profil.php';</script>";
            exit;
        }
        $logo = 'logo_' . time() . '.png';
        move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/logo/' . $logo);
    }

    if (!empty($_FILES['tanda_tangan']['name'])) {
        $ttd_ext = strtolower(pathinfo($_FILES['tanda_tangan']['name'], PATHINFO_EXTENSION));
        $ttd = 'ttd_' . time() . '.' . $ttd_ext;
        move_uploaded_file($_FILES['tanda_tangan']['tmp_name'], 'assets/tanda_tangan/' . $ttd);
    }

    if (!empty($_FILES['background']['name'])) {
        $bg_ext = strtolower(pathinfo($_FILES['background']['name'], PATHINFO_EXTENSION));
        $bg = 'bg_' . time() . '.' . $bg_ext;
        move_uploaded_file($_FILES['background']['tmp_name'], 'assets/background/' . $bg);
    }

    if (!empty($_FILES['background_belakang']['name'])) {
        $bg2_ext = strtolower(pathinfo($_FILES['background_belakang']['name'], PATHINFO_EXTENSION));
        $bg2 = 'bg2_' . time() . '.' . $bg2_ext;
        move_uploaded_file($_FILES['background_belakang']['tmp_name'], 'assets/background_belakang/' . $bg2);
    }

    $update = mysqli_query($conn, "UPDATE pengaturan SET
        nama_sekolah = '$nama',
        alamat = '$alamat',
        kepala_sekolah = '$kepala',
		nip_kepala_sekolah = '$nip_kepala',
        tanggal_ttd = '$tanggal',
        logo = '$logo',
        tanda_tangan = '$ttd',
        background = '$bg',
        background_belakang = '$bg2'
        WHERE id = 1");

    if ($update) {
        echo "<script>alert('Profil sekolah berhasil disimpan');location.href='edit_profil.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan profil sekolah');location.href='edit_profil.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Profil Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f0f2f5;
            color: #1c1e21;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #145DA0;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        p {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccd0d5;
            border-radius: 6px;
            background-color: #fff;
            box-sizing: border-box;
        }

        img.preview {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #145DA0;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0f4c81;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #145DA0;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            form {
                padding: 20px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <h2>Pengaturan Sekolah</h2>
    <form method="post" enctype="multipart/form-data">
        <p>
            <label for="nama_sekolah">Nama Sekolah:</label>
            <input type="text" name="nama_sekolah" id="nama_sekolah" value="<?= htmlspecialchars($sekolah['nama_sekolah']) ?>" required>
        </p>
        <p>
            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="3" required><?= htmlspecialchars($sekolah['alamat']) ?></textarea>
        </p>
        <p>
            <label for="kepala_sekolah">Kepala Sekolah:</label>
            <input type="text" name="kepala_sekolah" id="kepala_sekolah" value="<?= htmlspecialchars($sekolah['kepala_sekolah']) ?>" required>
        </p>
		<p>
            <label for="nip_kepala_sekolah">NIP Kepala Sekolah:</label>
            <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah" value="<?= htmlspecialchars($sekolah['nip_kepala_sekolah']) ?>" required>
        </p>
        <p>
            <label for="tanggal_ttd">Tanggal TTD:</label>
            <input type="date" name="tanggal_ttd" id="tanggal_ttd" value="<?= htmlspecialchars($sekolah['tanggal_ttd']) ?>" required>
        </p>
        <p>
            <label for="logo">Logo (.png):</label>
            <input type="file" name="logo" id="logo" accept=".png" onchange="previewImage(this, 'logo_preview')">
            <?php if (!empty($sekolah['logo'])): ?>
                <img src="assets/logo/<?= $sekolah['logo'] ?>" alt="Logo" class="preview" id="logo_preview">
            <?php else: ?>
                <img class="preview" id="logo_preview" style="display:none;">
            <?php endif; ?>
        </p>
        <p>
            <label for="tanda_tangan">Tanda Tangan Kepala Sekolah:</label>
            <input type="file" name="tanda_tangan" id="tanda_tangan" onchange="previewImage(this, 'ttd_preview')">
            <?php if (!empty($sekolah['tanda_tangan'])): ?>
                <img src="assets/tanda_tangan/<?= $sekolah['tanda_tangan'] ?>" alt="Tanda Tangan" class="preview" id="ttd_preview">
            <?php else: ?>
                <img class="preview" id="ttd_preview" style="display:none;">
            <?php endif; ?>
        </p>
        <p>
            <label for="background">Background Kartu:</label>
            <input type="file" name="background" id="background" onchange="previewImage(this, 'bg_preview')">
            <?php if (!empty($sekolah['background'])): ?>
                <img src="assets/background/<?= $sekolah['background'] ?>" alt="Background" class="preview" id="bg_preview">
            <?php else: ?>
                <img class="preview" id="bg_preview" style="display:none;">
            <?php endif; ?>
        </p>
        <p>
            <label for="background_belakang">Background Kartu Belakang:</label>
            <input type="file" name="background_belakang" id="background_belakang" onchange="previewImage(this, 'bg2_preview')">
            <?php if (!empty($sekolah['background_belakang'])): ?>
                <img src="assets/background_belakang/<?= $sekolah['background_belakang'] ?>" alt="Background Belakang" class="preview" id="bg2_preview">
            <?php else: ?>
                <img class="preview" id="bg2_preview" style="display:none;">
            <?php endif; ?>
        </p>
        <button type="submit" name="simpan">Simpan Pengaturan</button>
    </form>
    <a href="dashboard.php">← Kembali ke Dashboard</a>

    <script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>
