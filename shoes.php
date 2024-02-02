<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['userlogin'])) {
    header('Location: logadmin.php');
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == "edit") {
        $plus = mysqli_query($koneksi, "SELECT * FROM sepatu WHERE kode_sepatu='$_GET[kode_sepatu]'");
        while ($data = mysqli_fetch_array($plus)) {
            $model = $data['model'];
            $stok = $data['stok'];
            $harga = $data['harga'];
            $foto = $data['foto'];
        }
    } elseif ($_GET['aksi'] == 'hapus') {
        $plus = mysqli_query($koneksi, "DELETE FROM sepatu WHERE kode_sepatu='$_GET[kode_sepatu]'");
    }
}

if (isset($_POST['submit'])) {
    if ($_GET['aksi'] == "edit") {
        $kode_sepatu = $_GET['kode_sepatu'];
        $model = $_POST['model'];;
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $foto = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'Foto Sepatu/' . $foto);

        $edit = mysqli_query($koneksi, "UPDATE sepatu SET model ='$model', stok ='$stok', harga ='$harga', foto ='$foto' where kode_sepatu='$kode_sepatu'");
        if ($edit) {
            header("Location: shoes.php");
        }
    } else {
        $model = $_POST['model'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $foto = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'Foto Sepatu/' . $foto);

        $tambah = mysqli_query($koneksi, "INSERT INTO sepatu(model, stok, harga, foto) VALUES('$model','$stok', '$harga', '$foto')");
        if ($tambah) {
            header("Location: shoes.php");
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Admin Sidebar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <?php
                $id = $_SESSION['id_penjual'];
                $plus = mysqli_query($koneksi, "SELECT * FROM penjual WHERE id_penjual='$id'");
                $data = mysqli_fetch_array($plus);
                ?>
                <img class="img logo rounded-circle mb-5" src="Img/<?php echo $data['foto'] ?>" alt="">
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">Home</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="shoes.php">Shoes</a>
                            </li>
                            <li>
                                <a href="admin.php">Admin</a>
                            </li>
                            <li>
                                <a href="transaksi.php">Transaction</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="footer">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="shoes.php">Shoes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="transaksi.php">Tranaction</a>
                            </li>
                            <li class="nav-item">
                                <a href="outadmin.php" class="nav-link">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <form action="" method="post" enctype="multipart/form-data">
                <table width="25%" border=0>
                    <tr>
                        <td> Model </td>
                        <td><input type="text" name="model" value=<?= @$model ?>></td>
                    </tr>
                    <tr>
                        <td> Stock </td>
                        <td><input type="text" name="stok" value=<?= @$stok ?>></td>
                    </tr>
                    <tr>
                        <td> Harga </td>
                        <td><input type="text" name="harga" value=<?= @$harga ?>></td>
                    </tr>
                    <tr>
                        <td> Photo </td>
                        <td><input type="file" name="foto" value=<?= @$foto ?>></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="submit" value="Add"></td>
                    </tr>
                </table>
            </form>
            <table border=1>
                <thead>
                    <th> No. </th>
                    <th> Model </th>
                    <th> Stok </th>
                    <th> Price </th>
                    <th> Photo </th>
                    <th> Action </th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM sepatu");
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr style='justify-content: center; text-align: center;'>";
                        echo "<td style='padding: 5px;'>" . $no;
                        $no++ . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['model'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['stok'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['harga'] . "</td>";
                        echo "<td style='padding: 5px;'><img src='Foto Sepatu/{$data['foto']}' style= 'width: 300px;'></td>";
                        ?>
                        <td> <a href="shoes.php?aksi=edit&kode_sepatu=<?= $data['kode_sepatu'] ?>"> Edit </a>
                            <a href="shoes.php?aksi=hapus&kode_sepatu=<?= $data['kode_sepatu'] ?>"> Delete </a>
                        </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <script src="js/jquery.min.js"></script>
            <script src="js/popper.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/main.js"></script>
</body>

</html>