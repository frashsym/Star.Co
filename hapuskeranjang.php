<?php
session_start();
$kode = $_GET["id"];
unset($_SESSION["keranjang"][$kode]);
header("Location: keranjang.php");
?>