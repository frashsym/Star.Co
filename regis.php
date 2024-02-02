<?php
session_start();
include 'koneksi.php';

$host = "localhost"; // Ganti dengan host basis data Anda
$usersign = "root"; // Ganti dengan username basis data Anda
$passsign = ""; // Ganti dengan passsign basis data Anda
$database = "toko_sepatu"; // Ganti dengan nama basis data Anda

// Membuat koneksi ke basis data
$conn = new mysqli($host, $usersign, $passsign, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengamankan input dari form
function secureInput($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

if (isset($_POST['register'])) {
    $usersign = secureInput($_POST["usersign"]);
    $nama = secureInput($_POST["nama"]);
    $email = secureInput($_POST["email"]);
    $passsign = secureInput($_POST["passsign"]);
    $alamat = secureInput($_POST["alamat"]);
    $nomor = secureInput($_POST["nomor"]);
    $foto = secureInput($_POST["foto"]);

    // Lakukan validasi apakah form kosong atau tidak
    if (empty($usersign) && empty($nama) && empty($email) && empty($passsign) && empty($alamat) && empty($nomor) && empty($foto)) {
        $error = "<h1><center>Semua field harus diisi!</center></h1>";
    } else {
        $sql = "INSERT INTO pengguna (username, nama, email, password, alamat, no_hp, foto) VALUES ('$usersign','$nama','$email', '$passsign', '$alamat', '$nomor', '$foto')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit;
        } else {
            echo "Terjadi kesalahan";
        }
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Sign In Form</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -80px;
        }

        form {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            margin-top: 200px;
            margin-bottom: 200px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .social .fb {
            margin-left: 25px;
        }

        .social i {
            margin-right: 4px;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post">
        <h3>Sign In Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" name="usersign">

        <label for="name">Name</label>
        <input type="text" placeholder="Your Name" name="nama">

        <label for="email">Email</label>
        <input type="email" placeholder="Your Email" name="email">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="passsign">

        <label for="alamat">Address</label>
        <input type="text" placeholder="Your Address" name="alamat">

        <label for="nomor">Phone Number</label>
        <input type="text" placeholder="Phone Number" name="nomor">

        <label for="foto">Photo</label>
        <input type="file" placeholder="Your Photo" name="foto">

        <button type="submit" name="register">Signup</button>
        <p> <a href="login.php">Have an account?</a></p>
    </form>
</body>

</html>