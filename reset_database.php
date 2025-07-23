<?php
// Konfigurasi koneksi
$host = "localhost";
$user = "aeddggfw_kartuawal";
$pass = "aeddggfw_kartuawal";
$dbname = "aeddggfw_kartuawal";

// Lokasi file .sql
$sqlFile = "database_kartu_pelajar_master_v2.sql";

// Buat koneksi ke MySQL
$conn = new mysqli($host, $user, $pass);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Drop dan buat ulang database (opsional, hati-hati!)
$conn->query("DROP DATABASE IF EXISTS $dbname");
$conn->query("CREATE DATABASE $dbname");
$conn->select_db($dbname);

// Baca isi file SQL
$sql = file_get_contents($sqlFile);

if (!$sql) {
    die("Gagal membaca file SQL.");
}

// Eksekusi query multi-statement
if ($conn->multi_query($sql)) {
    do {
        // Proses semua hasil (jika ada)
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());

    echo "Restore database berhasil.";
} else {
    echo "Restore database gagal: " . $conn->error;
}

$conn->close();
?>
