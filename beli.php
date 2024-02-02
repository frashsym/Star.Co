<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://github.com/sweetalert2/sweetalert2.git">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://github.com/sweetalert2/sweetalert2.git"></script>
<body>
<?php
include "koneksi.php";
session_start();
//mendapat id produk dari
$kode_sepatu = $_GET['id'];
$_SESSION['id'] = $kode_sepatu;
if (!isset($_SESSION['username'])) {
    echo "<script>
    alert('Please be login');
    location='login.php';
    </script>";
}
//jika sudah menambah barang, +1 barang
if (isset($_SESSION['keranjang'][$kode_sepatu])) {
    $_SESSION['keranjang'][$kode_sepatu] += 1;
    echo "<script>
    alert('Product added to the cart');
    location='index.php';
    </script>";
}
//jika belum, nambah barang ini
else {
    $_SESSION['keranjang'][$kode_sepatu] = 1;
    echo "<script>
    alert('Product added to the cart');
    location='index.php';
    </script>";
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
    <script>
        function Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
    crossorigin="anonymous"></script>
</html>
