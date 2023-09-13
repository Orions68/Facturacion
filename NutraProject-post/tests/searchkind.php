<?php
include "includes/conn.php";
$title = "Facturando por Marca";
include "includes/header.php";
include "includes/modal-dismiss.html";
if (isset($_POST["kind"]))
{
    $name = $_POST["username"];
    $kind = $_POST["kind"];
    $i = 0;
    $sql = "SELECT * FROM products WHERE kind='$kind'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $product[$i] = $row->product;
            $price[$i] = $row->price;
            $qtty[$i] = $row->stock;
            $id[$i] = $row->id;
            $i++;
        }
    }
}
?>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
				<img alt="logo" src="img/logo.jpg" height="300" width="100%"/>
					<br><br>
                    <h1>Tenemos estos Productos del tipo <?php echo $kind; ?></h1>
                    <br><br>
                    <label><select name="kind">
                        <option value="">Selecciona el Producto</option>
                    <?php
                    for ($i = 0; $i < count($product); $i++)
                    {
                        if ($qtty[$i] > 0)
                        {
                            if ($qtty[$i] >= 11) // Si es mayor que 11, normal.
							{
                                echo "<option value='" . $id[$i] . "," . $product[$i] . "," . $price[$i] . "," . $qtty[$i] . "'>" . $product[$i] . " Precio: " . number_format((float)$price[$i], 2, ",", ".") . "</option>";
                            }
                            else if ($qtty[$i] < 11 && $qtty[$i] > 5)
                            {
                                echo "<option style='color: yellow; background-color: darkgray;' value='" . $id[$i] . "," . $product[$i] . "," . $price[$i] . "," . $qtty[$i] . "'>" . $product[$i] . " Precio: " . number_format((float)$price[$i], 2, ",", ".") . "</option>";
                            }
                            else
                            {
                                echo "<option style='color: red; background-color: lightgray;' value='" . $id[$i] . "," . $product[$i] . "," . $price[$i] . "," . $qtty[$i] . "'>" . $product[$i] . " Precio: " . number_format((float)$price[$i], 2, ",", ".") . "</option>";
                            }
                        }
                    }
                    ?>
                    </select> Selecciona el Producto</label>
                </div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<footer class="text-center text-lg-start bg-light text-muted">
	<div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
		WEB Design © 2022 César Osvaldo Matelat Borneo.
	</div>
</footer>
<script>screen()</script>
<script>resolution();</script>
	<!-- Script para detectar si la pantalla modifica su tamaño horizontal -->
	<script>
		window.addEventListener('resize', resolution);
		resolution();
	</script>
</body>

</html>