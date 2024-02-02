<?php
session_start();
include 'koneksi.php';
include 'tax.php';

if (!isset($_SESSION["username"])) {
    echo "<script>
    alert('Please be login');
    location='login.php';
    </script>";
} elseif (empty($_SESSION["keranjang"]) || !isset($_SESSION["keranjang"])) {
    echo "<script>
    alert('Cart is empty, please shop :)');
    location='index.php';
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://github.com/sweetalert2/sweetalert2.git">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://github.com/sweetalert2/sweetalert2.git"></script>
</head>

<body>
  <div>
    <nav class="navbar navbar-expand-lg bg-danger">
      <div class="container-fluid">
        <a class="navbar-brand" href="#navbar">
          <h1><span>Star</span>.Co</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php#navbar">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#about">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#catalog">Catalog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#contact">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="keranjang.php"><img src="../landing/Img/cart.png" alt="" width="25px"
                  height="25px"></a>
            </li>
            <?php
            // Periksa apakah sesi "username" sudah ada
            if (isset($_SESSION['username'])) {
              // Jika sudah login, tampilkan tombol logout
              echo '<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>';
            } else {
              // Jika belum login, tampilkan tombol login
              echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>';
            }
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            ?>
            <div class="btn-group dropstart" style="margin-left: 640px;">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Profile
              </button>
              <ul class="dropdown-menu">
                <?php
                if (isset($_SESSION['id_pengguna'])) {
                  $id = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;
                  $foto = $_SESSION['foto'];
                  $username = $_SESSION['username'];
                  $name = $_SESSION['nama'];
                  $email = $_SESSION['email'];
                  $address = $_SESSION['alamat'];
                  $phone = $_SESSION['no_hp'];
                  $plus = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$id'");
                  $data = mysqli_fetch_array($plus);
                  echo "<img class='mx-5' style='width: 60px; height: 60px; border-radius: 50%;' src='Img/{$foto}'><br>
                  <center>
                  <table width='25%' border='0'>
                  <tr>
                  <td> Username : {$username}<br><br> </td>
              </tr>
              <tr>
                  <td>{$email}<br><br> </td>
              </tr>
              </table>
              </center>";
                } else {
                  echo "<img class='mx-5' style='width: 60px; height: 60px; border-radius: 50%;' src='Img/Profil.JPG'>";
                }
                ?>
              </ul>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </div>

    <section class="konten">
        <div class="container">
            <h1>Your Cart</h1>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    foreach ($_SESSION["keranjang"] as $kode => $jumlah): ?>
                        <?php
                        $ambil = $koneksi->query("SELECT * FROM sepatu WHERE kode_sepatu = '$kode'");
                        $pecah = $ambil->fetch_assoc();
                        $totalharga = $pecah["harga"] * $jumlah;
                        ?>
                        <tr>
                            <td>
                                <?php echo $nomor; ?>
                            </td>
                            <td>
                                <?php echo $pecah['model']; ?>
                            </td>
                            <td>
                                <?php echo "Rp. " . number_format($pecah['harga']); ?>
                            </td>
                            <td>
                                <?php echo $jumlah; ?>
                            </td>
                            <td>
                                <?php echo "Rp. " . number_format($totalharga); ?>
                            </td>
                            <td><a class="btn btn-danger" href="hapuskeranjang.php?id=<?php echo $kode ?>">Delete</a></td>
                        </tr>
                        <?php
                        $nomor++;
                    endforeach;
                    if (isset($_GET['action']) == 'beli') {
                        $total = 0;
                        foreach ($_SESSION["keranjang"] as $kode => $jumlah) {
                            $total = $total + ($pecah["harga"] * $jumlah);
                        }
                        $id = $_SESSION['id_pengguna'];
                        $tanggal_pembelian = date('Y-m-d');

                        $tambah = mysqli_query($koneksi, "INSERT INTO transaksi(id_pengguna, total, tgl_beli) VALUES('$id', '$total', '$tanggal_pembelian')");
                        $id_trans = mysqli_insert_id($koneksi);
                        try {
                            foreach ($_SESSION["keranjang"] as $kode => $jumlah) {
                                $kode_sepatu = $kode;
                                $detail = mysqli_query($koneksi, "INSERT INTO detail(id_transaksi, kode_sepatu, jumlah) VALUES('$id_trans', '$kode_sepatu', '$jumlah')");
                            }
                        } catch (exception $error) {
                            echo "error: {$error->getMessage()} ";

                        }

                        unset($_SESSION['keranjang']);
                        echo "<script>
alert('Thank you for shopping at our store')
window.location='struk1.php?id={$id_trans}'
</script>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-default">Back</a>
            <a href="keranjang.php?action=beli" class="btn btn-danger">Check out</a>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
    crossorigin="anonymous"></script>

</html>
<?php

?>