<?php
    session_start();
    $koneksi = mysqli_connect("localhost","root","","product_details");

    if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                
                echo '<script>alert("Produk berhasil dimasukkan keranjang")</script>';
                echo '<script>window.location="cart_view.php"</script>';
               
            }else{
                echo '<script>alert("Produk sudah ada di keranjang")</script>';
                echo '<script>window.location="cart_view.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;

            echo '<script>alert("Produk berhasil dimasukkan keranjang")</script>';
            echo '<script>window.location="cart_view.php"</script>';

        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $key => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$key]);
                    echo '<script>alert("Product has been Removed...!")</script>';
                    echo '<script>window.location="cart_view.php"</script>';
                }
            }
        }elseif($_GET["action"] == "beli"){
            
            foreach($_SESSION["cart"] as $key => $value){
                $total = $total + ($value["item_quantity"] * $value["product_price"]);
            }
            $query = mysqli_query($koneksi, "INSERT INTO trans (date_trans,total_harga) VALUE ('".date("Y-m-d")."','$total')");
            $id_trans = mysqli_insert_id($koneksi);

            foreach($_SESSION["cart"] as $key => $value){
                $id_prod = $value['product_id'];
                $qty = $value['item_quantity'];
                $sql = "INSERT INTO detail (id_trans,id_prod,qty) VALUES ('$id_trans', '$id_prod', '$qty')";
                $res = mysqli_query($koneksi, $sql); 
            }
            
            unset($_SESSION["cart"]);
            echo '<script>alert("Terima kasih sudah berbelanja!")</script>';
            echo "<script>window.location='cetak.php?id=".$id_trans."'</script>";

        }
    }
    
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');

        *{
            font-family: 'Titillium Web', sans-serif;
        }
        .product{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        h2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
    </style>
</head>
<body>

    <div class="container" style="width: 65%">
    <a href="index.php" class="btn btn-info">Lanjutkan belanja</a>

        <div style="clear: both"></div>
        <h3 class="title2">Shopping Cart Details</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Nama Barang</th>
                <th width="10%">Qty</th>
                <th width="13%">Harga Barang</th>
                <th width="10%">Total Harga</th>
                <th width="17%">Aksi</th>
            </tr>

            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>    
                            <td><?=$value["item_name"]?></td>
                            <td><?=$value["item_quantity"]?></td>
                            <td>Rp <?=$value["product_price"]?></td>
                            <td>
                                Rp <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                            <td>
                                <a href="cart_view.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span class="text-danger">Hapus</span></a>
                            </td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Grand Total</td>
                            <th align="right">Rp <?php echo number_format($total, 2); ?></th>
                            <td>
                                <a href="cart_view.php?action=beli"><span class="text-danger">Beli</span></a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>

    </div>


</body>
</html>
