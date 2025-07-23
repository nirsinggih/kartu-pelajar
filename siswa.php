<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'siswa') {
    header('Location: index.php');
    exit;
}

require 'db.php';

$user_id = $_SESSION['id'];

// Ambil data siswa
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE user_id = $user_id");
$siswa = mysqli_fetch_assoc($query);

// Proses update data
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $tempat = mysqli_real_escape_string($conn, $_POST['tempat']);
    $tgl = mysqli_real_escape_string($conn, $_POST['tgl']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    mysqli_query($conn, "UPDATE siswa SET 
        nama = '$nama',
        jenis_kelamin = '$jk',
        tempat_lahir = '$tempat',
        tanggal_lahir = '$tgl',
        kelas = '$kelas'
        WHERE user_id = $user_id");

    header("Location: siswa.php");
    exit;
}

// Proses update foto
if (isset($_POST['upload_foto']) && isset($_FILES['foto']['tmp_name'])) {
    $target = 'foto/' . $siswa['nisn'] . '.jpg';
    move_uploaded_file($_FILES['foto']['tmp_name'], $target);
    header("Location: siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #000000;
            padding: 20px;
            margin: 0;
        }

        h2, h3 {
            color: #003366;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 30px;
            max-width: 500px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select,
        input[type="file"] {
            padding: 10px;
            width: 100%;
            max-width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            background-color: #1877f2; /* Biru tua ala Facebook */
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #145dbf;
        }

        img {
            margin-top: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 150px;
            height: auto;
            display: block;
        }

        a {
            color: #1877f2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            body {
                padding: 15px;
            }

            input[type="text"],
            input[type="date"],
            select {
                font-size: 16px;
            }

            button {
                width: 100%;
            }

            img {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <h2>Profil Siswa</h2>

    <form method="post">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>

        <label>Jenis Kelamin</label>
        <select name="jk" required>
            <option value="L" <?php if ($siswa['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
            <option value="P" <?php if ($siswa['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
        </select>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat" value="<?php echo htmlspecialchars($siswa['tempat_lahir']); ?>">

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl" value="<?php echo $siswa['tanggal_lahir']; ?>">

        <label>Kelas</label>
        <input type="text" name="kelas" value="<?php echo htmlspecialchars($siswa['kelas']); ?>" required>

        <button type="submit" name="update">Simpan Perubahan</button>
    </form>

    <h3>Foto Siswa</h3>
    <?php
    $foto_path = 'foto/' . $siswa['nisn'] . '.jpg';
    if (file_exists($foto_path)) {
        echo '<img src="' . $foto_path . '?t=' . time() . '" alt="Foto Siswa">';
    } else {
        echo "<p>Belum ada foto.</p>";
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <label>Ganti Foto (JPG)</label>
        <input type="file" name="foto" accept=".jpg" required>
        <button type="submit" name="upload_foto">Upload Foto</button>
    </form>

    <p><a href="logout.php">Logout</a></p>

</body>
</html>
