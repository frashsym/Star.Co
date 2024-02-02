<?php
$koneksi = new mysqli("localhost", "root", "", "toko_sepatu");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>