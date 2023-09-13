<?php
include "includes/conn.php";
$title = "Agregando Producto";
include "includes/header.php";
include "includes/modal-dismiss.html";
// Este script recibe los datos de un nuevo producto que se agregará a la base de datos.
$product = $_POST['product'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$kind = explode("$", $_POST["kind"]);
$brand = explode("$", $_POST['brand']);
$description = $_POST["description"];
$path = htmlspecialchars($_FILES["img"]["name"]);
$tmp = htmlspecialchars($_FILES["img"]["tmp_name"]);
$img = "img/" . basename($path);
move_uploaded_file($tmp, $img);
$sql = "INSERT INTO kind VALUES(:id, :kind);";
$stmt = $conn->prepare($sql);
$stmt->execute(array('id' => NULL, ':kind' => $kind[0]));
$sql = "INSERT INTO brand VALUES(:id, :brand);";
$stmt = $conn->prepare($sql);
$stmt->execute(array('id' => NULL, ':brand' => $brand[0]));
$stmt = $conn->prepare('INSERT INTO product VALUES(:id, :product, :price, :stock, :img, :kind, :brand, :description);');
$stmt->execute(array(':id' => null, ':product' => $product, ':price' => $price, ':stock' => $stock, ':img' => $img, ':kind' => $kind[0], ':brand' => $brand[0], ':description' => $description));
?>
<img alt="logo" src="img/logo.webp" height="300" width="100%"/>
<br>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
                    <script>toast('0', 'El Producto : <?php echo $product;?>', 'Se ha agregado correctamente.');</script>
                    <br><br>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>