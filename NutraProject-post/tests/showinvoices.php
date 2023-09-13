<?php
include "includes/conn.php";
$title = "Facturas por Días";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["date"]))
{
    $date = $_POST["date"];
    $i = 0;

    $stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();

    $sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date='$date' ORDER BY time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        $realqtty = [];
        $realprice = [];
        $price = [];
        $partial = [];
        $counter = 0;

        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $id[$i] = $row->id;
            $client[$i] = $row->client_id;
            $client[$i] = "";
            $client[$i] = getClient($conn, $client[$i]);
            $product[$i] = $row->product_id;
            $productArray = explode(",", $product[$i]);
            $product[$i] = "";
            $qtty[$i] = $row->qtty;
            $qttyArray = explode(",", $qtty[$i]);
            $qtty[$i] = "";
            $base[$i] = $row->partial;
            $total[$i] = $row->total;
            $iva[$i] = $row->iva;
            $date = $row->date;
            $time[$i] = $row->time;
            $i++;
            for ($n = 0; $n < count($qttyArray) - 1; $n++)
            {
                $qtty[$counter] .= $qttyArray[$n] . "<br>";
                $realqtty[$n] = $qttyArray[$n];
                $product[$counter] .= getProduct($conn, $productArray[$n], $counter);
                array_push($partial, $realprice[$n] * $realqtty[$n] . " €<br>");
            }
            $counter++;
        }
    }
}

function getClient($conn, $id)
{
    if ($id == null)
    {
        $client = "Consumidor Final";
        return $client;
    }
    else
    {
        $sql = "SELECT name FROM clients WHERE id=$id";
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
    $sql = "SELECT product, price FROM products WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row_product = $stmt->fetch(PDO::FETCH_OBJ);
    array_push($price, $row_product->price . " €<br>");
    $realprice[$counter] = $row_product->price;
    $product = $row_product->product . "<br>";
    return $product;
}
    ?>
<section class="container-fluid pt-3">
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width:3%;"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Facturas del Día: <?php echo $date; ?></h1>
                    <br><br>
                <?php
                for ($j = 0; $j < $i; $j++)
                {
                    echo '<div id="printable' . $j . '">
                        <h3>Nutra Project</h3>
                        <h4>Factura  Nº: ' . $id[$j] . ', a ' . $client[$j] . ' Fecha: ' . $date . '</h4>
                        <div class="row">
                            <div style="width: 1px;"></div>
                            <div class="column left" style="background-color:#d0d0d0;">&nbsp;
                            Artículos
                            </div>
                            <div class="column left" style="background-color:#d6d6d6;">&nbsp;
                            Precio
                            </div>
                            <div class="column middle" style="background-color:#dbdbdb;">
                            Cantidad
                            </div>
                            <div class="column left" style="background-color:#dfdfdf;">&nbsp;
                            Parcial
                            </div>
                            <div class="column middle" style="background-color:#e0e0e0;">
                            Base Imponible
                            </div>
                            <div class="column right" style="background-color:#e6e6e6">
                            I.V.A.
                            </div>
                            <div class="column middle" style="background-color:#ebebeb;">
                            A Pagar de I.V.A.
                            </div>
                            <div class="column moreright" style="background-color:#efefef;">
                            Total + I.V.A.
                            </div>
                        </div>
                        <div class="row">
                            <div style="width: 1px;"></div>
                            <div class="column left" style="background-color:#d0d0d0;">' . $product[$j] . '
                            </div>
                            <div class="column left" style="background-color:#d6d6d6; text-align:right;">' . $price[$j] . '
                            </div>
                            <div class="column middle" style="background-color:#dbdbdb;">' . $qtty[$j] . '
                            </div>
                            <div class="column left" style="background-color:#dfdfdf;">' . $partial[$j] . '
                            </div>
                            <div class="column moreright" style="background-color:#e0e0e0;">' . number_format((float)$base[$j], 2, ',', '.') . ' €
                            </div>
                            <div class="column right" style="background-color:#e6e6e6;">21 %
                            </div>
                            <div class="column moreright" style="background-color:#ebebeb;">' . number_format((float)$iva[$j], 2, ',', '.') . ' €
                            </div>
                            <div class="column moreright" style="background-color:#efefef;">' . number_format((float)$total[$j], 2, ',', '.') . ' €
                            </div>
                        </div>
                        <div class="row">
                            <div class="column total">Total I.V.A. Incluido: ' . number_format((float)$total[$j], 2, ",", ".") . ' €</div>
                        </div>
                    </div>
                    <a id="image' . $j . '" download="Factura Nº ' . $id[$j] . '.png"></a>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="printIt(' . $j . ')" style="width:160px; height:80px;" class="btn btn-primary">Imprimir Ticket</button>
                        </div>
                        <div class="col-md-6">
                        <button onclick="window.open(\'saveIt.php?id=' . $id[$j] . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guardar Factura en Exel</button>
                            <script>capture(' . $j . ');</script>
                        </div>
                    </div><br><br>';
                    $product1 = "";
                    $qtty1 = "";
                    $partial1 = "";
                    $price = "";
                }
				?>
                <br><br>
                <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
                    <br><br><br><br><br>
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>