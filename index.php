<?php
session_start();
include 'koneksi.php';
$query = "SELECT * FROM sepatu";
$result = mysqli_query($koneksi, $query);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Happy shopping at Star.Co</title>
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
              <a class="nav-link active" aria-current="page" href="#navbar">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#catalog">Catalog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contact Us</a>
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

  <div>
    <header class="container-fluid bg-primary text-dark"
      style="justify-content: center; background-image: url('../landing/Foto Sepatu/sepatu1-c7c8a956c08d5240d23a9803c984bd4e-22ffecd713d12a13dab5a7afd37e2ead_wm_600x315.jpg'); background-size: cover; background-position: center; height: 60vh;">
      <div class="container col-lg-6"
        style="height: 100%; display: flex; justify-content: center; align-items: center;">
        <div class="row" id="navbar">
          <div>
            <h2 class="display-1 text-light">Welcome To Star.Co</h2>
          </div>
          <div>
            <p class="lead text-light">Here, we offer various types of shoes such as sports shoes, warrior shoes, and
              sneakers.</p>
          </div>
        </div>
    </header>
  </div>
  <hr>
  <center>
    <div class="row mt-5" id="about">
      <h3>About Us</h3>
      <div class="col-12 col-md-12">
        <img width="420px" height="280px" src="../landing/Foto Sepatu/sepatu 1.jpeg" alt="">
      </div>
      <br><br>
      <div class="col-12 col-md-12 border rounded p-4" id="about">
        <h1 class="mb-4">Shoes with five-star quality.</h1>
        <p>Welcome to Star.Co! We take pride in presenting an outstanding and high-quality collection of shoes that will
          enhance your style and provide comfort all day long. We are the ultimate destination for shoe enthusiasts
          seeking unmatched style.</p>
        <p>At Star.Co, we believe that shoes are not just footwear but also an expression of your style and personality.
          From classic styles to the latest trends, we offer a variety of shoes for every occasion and taste.</p>
      </div>
    </div>
  </center>
  <div>
    <br>
    <br>
    <center>
      <h2 id="catalog">Please choose an option</h2>
    </center>
  </div>
  <center>
    <div class="container">
      <div class="row gap-4 gap-sm-0">
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($data = mysqli_fetch_array($result)) {
            ?>

            <div class="col-md-6  col-lg-4">
              <form method="post" action="keranjang.php?id=<?php echo $data['kode_sepatu'] ?>">
                <div class="card" style="width: 18rem; margin-bottom: 20px;">
                  <img src="Foto Sepatu/<?= $data["foto"] ?>" class="card-img-top" alt="Shoes Image">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?= $data["model"] ?>
                    </h5>
                    <p class="card-text">Rp.
                      <?= $data["harga"] ?>
                    </p>
                    <a href="beli.php?id=<?= $data['kode_sepatu']; ?>">
                      <img src="../landing/Img/cart.png" style="margin-left: 15px;" width="25px;" height="25px;">
                    </a>

                  </div>
                </div>
              </form>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </center>
  <div>
    <footer class="container-fluid bg-dark text-light">
      <div class="text-center" id="contact">
        <h1>Contact Us</h1>
        <p>rfqfrashsym@gmail.com</p><br><br>
        <p>&copy;Copyright 2023</p>
      </div>
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
    crossorigin="anonymous"></script>
</body>

</html>