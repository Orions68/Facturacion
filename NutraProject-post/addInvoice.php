<?php
// Este script guarda las facturas en la base de datos.
include "includes/conn.php";
$title = "Guardando la Factura";
include "includes/header.php";
include "includes/modal-invoice.html";

if (isset($_POST["way"]))
{
    $way = $_POST["way"];

    for ($i = 0; $i < (count($_POST) - 2) / 4; $i++) // Hago un bucle hasta el tamaño del POST -1 ya que vienen 5 valores pero necesito obtener 4 y divido la cantidad por 4, para obtener la cantidad de elementos en los arrays.
    {
        $id[$i] = $_POST["id" . $i]; // En $id[$i] pongo los valores recibidos en $_POST["id0"], $_POST["id1"], etc.
        $product[$i] = $_POST["product" . $i];
        $price[$i] = $_POST["price" . $i];
        $qtty[$i] = $_POST["qtty" . $i];
        $partial = "";
        $j = 0;

        $sql = "UPDATE product SET stock=stock - $qtty[$i] WHERE id=$id[$i]"; // Descuento de la base de datos el stock de los artículos comprados.
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "SELECT * FROM product WHERE id=$id[$i]";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            while($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
                if ($row->stock <= 5) // Si el stock de alguno de los productos comprados es menor o igual a 5.
                {
                    $product[$j] = $row->product . " Queda en: " . $row->stock . " Artículos."; // Pongo en el array $product el nombre del producto y la cantidad que queda de él.
                    $j++;
                }
            }
        }
    }
    $date = date("Y-m-d"); // Obtengo la fecha del día de la facturación.
    $time = date("H:i:s"); // Obtengo la hora de la facturación.
}

if (count($product) > 0) // Si el array $product contiene algún dato.
{
    for ($i = 0; $i < count($product); $i++) // Hago un bucle a la cantidad de datos en $product.
    {
        echo "<script>toast('1', 'Cuidado el Stock de: ', " . $product[$i] . ");</script>"; // Muestro un aviso que quedan pocas unidades de los productos en el array $product.
    }
}

if (!empty($_SESSION["client"]))
{
    $client_id = $_SESSION["client"];
}
else
{
    $client_id = null;
}
$total = $_POST["total"];
$base = $total * 100 / 121;
$iva = $base * .21;
$products = "";
$qtty1 = "";
for ($i = 0; $i < count($id); $i++)
{
    $products .= $id[$i] . ",";
    $qtty1 .= $qtty[$i] . ",";
    $partial .= $price[$i] * $qtty[$i] . ",";
}
$stmt = $conn->prepare('INSERT INTO invoice VALUES(:id, :client_id, :product_id, :qtty, :partial, :iva, :total, :date, :time, :way)');
$stmt->execute(array(':id' => null, ':client_id' => $client_id, ':product_id' => $products, ':qtty' => $qtty1, ':partial' => $partial, ':iva' => $iva, ':total' => $total, ':date' => $date, ':time' => $time, ':way' => $way));
// Estas líneas agregan la factura a la base de datos.
?>
<img alt="logo" src="img/logo.webp" height="300" width="100%">
<br>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
                    <script>toast(0, 'Factura de Monto: <?php echo number_format((float)$total, 2, ",", ".");?>', 'Almacenada Correctamente en la base de datos.');</script>
					<br><br>
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>