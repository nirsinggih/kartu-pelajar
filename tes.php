<?php
include 'lib/SimpleXLSX.php'; // sesuaikan path dengan lokasi file sebenarnya
require_once 'lib/SimpleXLSX.php';

if (class_exists('SimpleXLSX')) {
    echo "✅ SimpleXLSX berhasil dimuat!";
} else {
    echo "❌ Class SimpleXLSX tidak ditemukan!";
}
?>
