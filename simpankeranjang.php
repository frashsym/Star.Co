<?php
include 'koneksi.php';
include 'tax.php';
session_start();
$total = 0;
foreach ($_SESSION["keranjang"] as $kode => $jumlah) {
    $total = $total + ($pecah["harga"] * $jumlah) + $tax;
}
$id = $_SESSION['id_pengguna'];
$tanggal_pembelian = date('Y-m-d');

$tambah = mysqli_query($koneksi, "INSERT INTO transaksi(id_pengguna, total, tgl_beli) VALUES('$id', '$total', '$tanggal_pembelian')");
unset($_SESSION['keranjang']);
?>