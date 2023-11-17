<?php
include "includes/conn.php";
$title = "Modificar/Eliminar un Artículo";
include "includes/header.php";
include "includes/modal-update.html";

if (isset($_POST["id"]))
{
	if (!isset($_POST["price"]))
	{
		$id = $_POST['id'];
		$product = $_POST['product'];
		$stmt = $conn->prepare("DELETE FROM product WHERE id=$id");
		$stmt->execute();
		echo "<script>toast(2, 'Producto Quitado:', 'El Producto " . $product . " ha Sido Quitado Correctamente.');</script>";
	}
	else
	{
		$product = $_POST['product'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		$kind = $_POST['kind'];
		$brand = $_POST['brand'];
		$id = $_POST['id'];
		$description = $_POST["description"];
		$path = htmlspecialchars($_FILES["img"]["name"]);
		if ($path != "")
		{
			$tmp = htmlspecialchars($_FILES["img"]["tmp_name"]);
			$img = "img/" . basename($path);
			move_uploaded_file($tmp, $img);
			$stmt = $conn->prepare("UPDATE product SET product='$product', price=$price, stock=stock + $stock, img='$img', kind='$kind', brand='$brand', description='$description' WHERE id=$id");
		}
		else
		{
			$stmt = $conn->prepare("UPDATE product SET product='$product', price=$price, stock=stock + $stock, kind='$kind', brand='$brand', description='$description' WHERE id=$id");
		}
		$stmt->execute();
		echo "<script>toast(0, 'Todo Ha Ido Bien:', 'Producto : " . $product . " Modificado correctamente.');</script>";
	}
}

?>
<img alt="logo" src="img/logo.webp" height="300" width="100%"/>
<br>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br>
					<h1>Menú Para Modificar o Eliminar los Productos.</h1>
					<?php
					$stmt = $conn->prepare('SELECT * FROM product');
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_OBJ))
					{
						echo '<br>
						<div style="border:4px solid blue;">
						<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id" value="' . $row->id . '">
						<label><input type="text" name="product" value="' . $row->product . '" style="width: 480px;"> Producto</label>
						<br><br>
						<label><input type="number" name="price" value="' . $row->price . '"> Precio</label>
						<br><br>
						<label><input type="number" name="stock" value="' . $row->stock . '"> Stock</label>
						<br><br>';
                        $kind = kind($conn, $row->kind);
                        $all = all("kind");
                        echo '<label><select name="kind">
                        <option value=""> Seleciona un Tipo</option>
                        <option value="' . $row->kind . '" selected="selected">' . $kind . '</option></select> Tipo</label>
						<br><br>';
                        $brand = brand($conn, $row->brand);
                        $all = all("brand");
                        echo '<label><select name="brand">
                        <option value=""> Seleciona una Marca</option>
                        <option value="' . $row->brand . '" selected="selected">' . $brand . '</option></select> Marca</label>
						<br><br>
						<label><input type="text" name="description" value="' . $row->description . '"> Descripción</label>
						<br><br>
						<label><input type="file" name="img"> Foto del Producto Ofrecido</label>
						<br><br>
						<input type="submit" value="Modificar" style="width:160px; height:60px;" class="btn btn-success">
						</form>
						<form action="" method="post">
						<input type="hidden" name="id" value="' . $row->id . '">
						<input type="hidden" name="product" value="' . $row->product . '">
						<br><br>
						<input type="submit" value="Borrar Producto." style="width:160px; height:60px;" class="btn btn-danger">
						</form>
						</div>';
					}

                    function kind($conn, $id)
                    {
                        $sql = "SELECT kind FROM kind WHERE product_id=$id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_OBJ);
                        return $row->kind;
                    }

                    function brand($conn, $id)
                    {
                        $sql = "SELECT brand FROM brand WHERE product_id=$id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_OBJ);
                        return $row->brand;
                    }

                    function all($which)
                    {
                        if ($which == "kind")
                        {
                            $sql = "SELECT kind FROM kind;";
                        }
                        else
                        {
                            $sql = "SELECT brand FROM brand";
                        }
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_OBJ);
                        return $row;
                    }
					?>
					<br><br>
					<input type="button" value="Cierra esta Ventana" onclick="window.close()">
					<br>
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>