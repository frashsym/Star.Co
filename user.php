<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['userlogin'])) {
    header('Location: logadmin.php');
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == "edit") {
        $plus = mysqli_query($koneksi, "SELECT * FROM penjual WHERE id_penjual='$_GET[id_penjual]'");
        while ($data = mysqli_fetch_array($plus)) {
            $nama = $data['nama'];
            $uname = $data['username'];
            $word = $data['password'];
            $no_hp = $data['no_hp'];
            $file = $data['foto'];
        }
    } elseif ($_GET['aksi'] == 'hapus') {
        $plus = mysqli_query($koneksi, "DELETE FROM penjual WHERE id_penjual='$_GET[id_penjual]'");
    }
}
if (isset($_POST['submit'])) {
    if ($_GET['aksi'] == "edit") {
        $id_peng = $_GET['id_penjual'];
        $nama = $_POST['nama'];
        $uname = $_POST['username'];
        $word = $_POST['password'];
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($file_tmp, 'Img/' . $file);

        $edit = mysqli_query($koneksi, "UPDATE penjual set nama ='$nama', username ='$uname', password ='$word', email ='$email', no_hp ='$no_hp', foto ='$file' where id_penjual='$id_peng'");
        if ($edit) {
            header("Location: user.php");
        }
    } else {
        $nama = $_POST['nama'];
        $uname = $_POST['username'];
        $word = $_POST['password'];
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($file_tmp, 'Img/' . $file);

        $tambah = mysqli_query($koneksi, "INSERT INTO penjual(nama, username, password, email, no_hp, foto) VALUES('$nama', '$uname', '$word', '$email', '$no_hp', '$file')");
        if ($tambah > 0) {
            header("Location: user.php");
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
                                <a href="user.php">Admin</a>
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
                                <a class="nav-link" href="user.php">Admin</a>
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
                        <td> Nama Admin </td>
                        <td><input type="text" name="nama" value=<?= @$nama ?>></td>
                    </tr>
                    <tr>
                        <td> Username </td>
                        <td><input type="text" name="username" value=<?= @$uname ?>></td>
                    </tr>
                    <tr>
                        <td> Password </td>
                        <td><input type="password" name="password" value=<?= @$word ?>></td>
                    </tr>
                    <tr>
                        <td> Email </td>
                        <td><input type="email" name="email" value=<?= @$email ?>></td>
                    </tr>
                    <tr>
                    <tr>
                        <td> No. Hp </td>
                        <td><input type="text" name="no_hp" value=<?= @$no_hp ?>></td>
                    </tr>
                    <tr>
                        <td> Foto </td>
                        <td><input type="file" name="file" value=<?= @$file ?>></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="submit" value="Tambah"></td>
                    </tr>
                </table>
            </form>
            <table border=1>
                <thead>
                    <th> No. </th>
                    <th> Nama Admin </th>
                    <th> Username </th>
                    <th> Password </th>
                    <th> Email </th>
                    <th> No. Hp </th>
                    <th> Foto </th>
                    <th> Aksi </th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM penjual");
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr style='justify-content: center; text-align: center;'>";
                        echo "<td style='padding: 5px;'>" . $no;
                        $no++ . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['nama'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['username'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['password'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['email'] . "</td>";
                        echo "<td style='padding: 5px;'>" . $data['no_hp'] . "</td>";
                        echo "<td style='padding: 5px;'><img src='Img/" . $data['foto'] . "' style= 'width: 300px;'></td>";
                        ?>
                        <td> <a href="user.php?aksi=edit&id_penjual=<?= $data['id_penjual'] ?>"> Edit </a>
                            <a href="user.php?aksi=hapus&id_penjual=<?= $data['id_penjual'] ?>"> Hapus </a>
                        </td><!--INI ERROR GOBLOK-->
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