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

    $sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date='$date' ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $id[$i] = $row->id;
            $client[$i] = $row->client;
            $job[$i] = $row->job;
            $hand[$i] = $row->hand;
            $total[$i] = $row->total;
            $date = $row->date;
            $i++;
        }

    }
}
    ?>
<section class="container-fluid pt-3">
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width:3%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <?php
                echo '<h1>Facturas del Día: ' . $date . '</h1>
                <br><br>';
                for ($j = 0; $j < $i; $j++)
                {
					echo '<div id="printable' . $j . '">
                        <h3>Fernando Ariel Filippelli - Y0575228N Camino La Unión 31 38270 Valle de Guerra</h3>
                        <h4>Factura  Nº: ' . $id[$j] . ', a ' . $client[$j] . ' Fecha: ' . $date . '</h4>
                        <div class="row">
                        <div style="width: 1px;"></div>
                            <div class="column left" style="background-color:#d0d0d0;">
                            Trabajo
                            </div>
                            <div class="column oneright" style="background-color:#e0e0e0;">
                            Mano de Obra
                            </div>
                            <div class="column final" style="background-color:#e8e8e8; text-align:right;">
                            Total
                            </div>
                        </div>
                        <div class="row">
                        <div style="width: 1px;"></div>
                            <div class="column left" style="background-color:#d0d0d0;">' . $job[$j] . '
                            </div>
                            <div class="column oneright" style="background-color:#e0e0e0;">' . number_format((float)$hand[$j], 2, ',', '.') . ' €
                            </div>
                            <div class="column final" style="background-color:#e8e8e8;">' . number_format((float)$total[$j], 2, ',', '.') . ' €
                            </div>
                        </div>
                        <div class="row">
                            <div class="column total">Total: ' . number_format((float)$total[$j], 2, ",", ".") . ' €</div>
                        </div>
                    </div>
                    <a id="image' . $j . '" download="Factura Nº ' . $id[$j] . '.png"></a>
                    <br><br><br><br>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="printIt(' . $j . ')" style="width:160px; height:80px;" class="btn btn-primary">Imprime la Factura</button>
                        </div>
                        <div class="col-md-5">
                        <button onclick="pdfDown(' . $j . ')" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                        </div>
                        <div class="col-md-3">
                        <button onclick="window.open(\'saveIt.php?id=' . $id[$j] . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guarda la Factura en Exel</button>
                            <script>capture(' . $j . ');</script>
                        </div>
                    </div><br><br><br>';
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