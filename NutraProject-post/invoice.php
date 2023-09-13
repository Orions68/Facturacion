<?php
include "includes/conn.php";
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set("Europe/Madrid");

$title = "Facturación de Nutra Project";
include "includes/header.php";
$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
$stmt->execute();
$sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice ORDER BY id desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id = $row->id;
$client = $row->client_id;
$client = getClient($conn, $row->client_id);

$product = $row->product_id;
$productArray = explode(",", $product);
$product = "";
$price = "";
$realprice = [];
$counter = 0;
for ($i = 0; $i < count($productArray) - 1; $i++)
{
    $product .= getProduct($conn, $productArray[$i], $counter);
    $counter++;
}
$qtty = $row->qtty;
$qttyArray = explode(",", $qtty);
$qtty = "";
$realqtty = [];
for ($i = 0; $i < count($qttyArray) - 1; $i++)
{
    $qtty .= $qttyArray[$i] . "<br>";
    $realqtty[$i] = $qttyArray[$i];
}
$total = $row->total;
$iva = $row->iva;
$base = $total - $iva;
$date = $row->date;
$time = $row->time;
$partial = "";

function getClient($conn, $id)
{
    if ($id == null)
    {
        $client = "Consumidor Final";
        return $client;
    }
    else
    {
        $sql = "SELECT name FROM client WHERE id=$id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row_client = $stmt->fetch(PDO::FETCH_OBJ);
        $client = $row_client->name;
        return $client;
    }
}

function getProduct($conn, $id, $counter)
{
    global $price, $realprice;
    $sql = "SELECT product, price FROM product WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row_product = $stmt->fetch(PDO::FETCH_OBJ);
    $price .= $row_product->price . " €<br>";
    $realprice[$counter] = $row_product->price;
    $product = $row_product->product . "<br>";
    return $product;
}
for ($i = 0; $i < count($realprice); $i++)
{
    $partial .= $realprice[$i] * $realqtty[$i] . " €<br>";
}
?>
<img alt="logo" src="img/logo.webp" height="300" width="100%"/>
<br>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
					<br><br>
					<?php
					echo '<div id="printable0">';
					echo "<h3>Nutra Project</h3>";
					echo "<h4>Factura Nº $id a: $client</h4>";
					echo '<div class="row">';
                        echo '<div style="width: 1px;"></div><div class="column left" style="background-color:#d0d0d0;">';
                        echo "Artículo";
                        echo '</div>';
                        echo '<div class="column middle" style="background-color:#d6d6d6;">';
                        echo "Precio";
                        echo '</div>';
                        echo '<div class="column right" style="background-color:#dbdbdb;">';
                        echo "Cantidad";
                        echo '</div>';
                        echo '<div class="column moreright" style="background-color:#dfdfdf;">';
                        echo "Parcial";
                        echo '</div>';
                        echo '<div class="column moreright" style="background-color:#e0e0e0;">';
                        echo "Base Imponible";
                        echo '</div>';
                        echo '<div class="column moreright" style="background-color:#e6e6e6; text-align:center;">';
                        echo "I.V.A.";
                        echo '</div>';
                        echo '<div class="column moreright" style="background-color:#ebebeb;">';
                        echo "A Pagar de I.V.A.";
                        echo '</div>';
                        echo '<div class="column moreright" style="background-color:#efefef;">';
                        echo "Total";
                        echo '</div>';
					echo '</div>';

					echo '<div class="row">
						<div style="width: 1px;"></div><div class="column left" style="background-color:#d0d0d0;">
						' . $product . '
						</div>
						<div class="column middle" style="background-color:#d6d6d6;">
						' . $price . '
						</div>
						<div class="column right" style="background-color:#dbdbdb;">
						' . $qtty . '
						</div>
                        <div class="column right" style="background-color:#dfdfdf;">
						' . $partial . '
						</div>
						<div class="column moreright" style="background-color:#e0e0e0;">
						' . number_format((float)$base, 2, ',', '.') . ' €
						</div>
						<div class="column moreright" style="background-color:#e6e6e6; text-align: center;">
						21 %
						</div>
                        <div class="column moreright" style="background-color:#ebebeb; text-align: center;">
						' . $iva . '
						</div>
						<div class="column moreright" style="background-color:#efefef;">
						' . number_format((float)$total, 2, ',', '.') . ' €
						</div>
					</div>
					<div class="row">
                                <div class="column total">Total I.V.A. Incluido: ' . number_format((float)$total, 2, ",", ".") . ' €
                            </div></div>
					</div><br><br><br><br>
					<a id="image0" download="Factura Nº ' . $id . '.png"></a>
                    <br><br><br><br>
                        <div class="row">
                        <div class="col-md-4">
                        <button onclick="printIt(-1)" style="width:160px; height:80px;" class="btn btn-primary">Imprimir Ticket</button>
                        </div>
                        <div class="col-md-5">
                        <button onclick="pdfDown(0)" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                        </div>
                        <div class="col-md-3">
                        <button onclick="window.open(\'saveIt.php?id=' . $id . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guardar Factura en Exel</button>
                        <script>capture(0);</script>
                        </div>
                        </div>';
					?>
                    <br><br>
                    <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>