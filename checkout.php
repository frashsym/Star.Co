<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["username"])) {
  echo "<script>
    alert('Please be login');
    location='login.php';
    </script>";
} elseif (!isset($_GET['id'])) {
  echo "<script>alert('Please buy some stuff'); location='index.php';</script>";
}
//New if

if (isset($_POST["submit"])) {
  $data = mysqli_fetch_array($result);
  $total = $data["harga"];
  $id = mysqli_real_escape_string($koneksi, $_POST['id']); // Ganti $_GET menjadi $_POST
  $tanggal_pembelian = date("Y-m-d");

  $tambah = mysqli_query($koneksi, "INSERT INTO transaksi(id_pengguna, total, tgl_beli) VALUES('$id', '$total', '$tanggal_pembelian')");
  if (!$tambah) {
    die(mysqli_error($koneksi));
  }

  $id_trans = mysqli_insert_id($koneksi);
  $kode = $data["kode_sepatu"];
  $jumlah = 1;
  $detail = mysqli_query($koneksi, "INSERT INTO detail(id_transaksi, kode_sepatu, jumlah) VALUES('$id_trans', '$kode', '$jumlah')");
  var_dump($total, $id, $tanggal_pembelian);

}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$tax = 10000;
$query = "SELECT * FROM sepatu WHERE kode_sepatu = '$id'";
$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                $id = isset($_SESSION['id_pengguna']) ? $_SESSION['id_pengguna'] : null;
                $foto = $_SESSION['foto'];
                $username = $_SESSION['username'];
                $name = $_SESSION['nama'];
                $email = $_SESSION['email'];
                $address = $_SESSION['alamat'];
                $phone = $_SESSION['no_hp'];
                $plus = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$id'");
                $data = mysqli_fetch_array($plus);
                if (isset($_SESSION['id_pengguna'])) {
                  echo "<img class='mx-5' style='width: 60px; height: 60px; border-radius: 50%;' src='Img/{$foto}'><br>
                  <center>
                  <table width='25%' border='0'>
                  <tr>
                  <td> Username :<br>{$username}<br><br> </td>
              </tr>
              <tr>
                  <td>Name :<br>{$name}<br><br> </td>
              </tr>
              <tr>
                  <td>Email :<br>{$email}<br><br> </td>
              </tr>
              <tr>
                  <td>Adress :<br>{$address}<br><br> </td>
              </tr>
              <tr>
                  <td>Phone :<br>{$phone}<br><br> </td>
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
  <br>
  <center>
    <?php
    while ($data = mysqli_fetch_array($result)) {
      ?>
      <form method="post" action="struk.php?id=<?= $data['kode_sepatu'] ?>">
        <div class="col-sm-4">
          <div class="card" style="width: 18rem; margin-bottom: 20px;">
            <center>
              <img src="Foto Sepatu/<?= $data["foto"] ?>" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">
                  <?= $data["model"] ?>
                </h5>
                <p class="card-text">Rp.
                  <?= $data["harga"] ?>
                </p>
                <p class="card-text">Tax =
                  <?= $tax ?>
                </p>
                <p class="card-text">
                  <?= $data["harga"] + $tax ?>
                </p>
                <input type="submit" name="submit" value="Checkout" class="btn btn-danger">
              </div>
            </center>
          </div>
        </div>
      </form>
      <?php
    }
    ?>
  </center>
</body>

</html>