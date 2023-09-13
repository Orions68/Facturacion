<?php
include "includes/conn.php";
include "includes/client.php";
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
        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $id[$i] = $row->id;
            $pat_id[$i] = $row->pat_id;
            $patient[$i] = getClient($conn, $pat_id[$i]);
            $job[$i] = $row->concept;
            $qtty[$i] = $row->qtty;
            $price[$i] = $row->partial;
            $total[$i] = $row->total;
            $irpf[$i] = $price[$i] * $qtty[$i] - $total[$i];
            $date = $row->date;
            $time[$i] = $row->time;
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
                    <h1>Facturas del Día: <?php echo $date; ?></h1>
                    <br><br>
                <?php
                for ($j = 0; $j < $i; $j++)
                {
                    echo '<div id="printable' . $j . '">
                    <div class="row">
                    <div class="col-md-2">
                            <h5>Factura Nº: ' . $id[$j] . '<br>a: ' . $patient[$j] . "<br>Fecha: " . $date . '</h5>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="img/tree.png" alt="Logo del Grupo Tagor">
                            <h3>Grupo Tagor</h3>
                            <h4>Begoña Moreno Megias - 42021197-J<br>C/. Juan Padrón núm. 11, 1º izq.<br> 38003 SANTA CRUZ DE TENERIFE<br>630738642<br>bmorenomegias@gmail.com</h4>
                            <br><br>
                        </div>
                    </div>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#e0e0e0; font-weight: bold; color: green;">Servicio
                                </div>
                                <div class="column right" style="background-color:#e5e5e5; font-weight: bold; color: green;">Cantidad
                                </div>
                                <div class="column middle" style="background-color:#eaeaea; font-weight: bold; color: green;">Base Imponible
                                </div>
                                <div class="column right" style="background-color:#f0f0f0; font-weight: bold; color: green;">I.R.P.F. 15%
                                </div>
                                <div class="column moreright" style="background-color:#f5f5f5; font-weight: bold; color: green;">Total Descontando I.R.P.F.
                                </div>
                            </div>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#e0e0e0;">' . $job[$j] . '
                                </div>
                                <div class="column right" style="background-color:#e5e5e5;">' . $qtty[$j] . '
                                </div>
                                <div class="column middle" style="background-color:#eaeaea;">' . number_format((float)$price[$j] * $qtty[$j], 2, ',', '.') . ' €
                                </div>
                                <div class="column right" style="background-color:#f0f0f0;">' . number_format((float)$irpf[$j], 2, ',', '.') . ' €
                                </div>
                                <div class="column moreright" style="background-color:#f5f5f5;"> ' . number_format((float)$price[$j] * $qtty[$j], 2, ',', '.') . ' € - ' . number_format((float)$irpf[$j], 2, ',', '.') . ' €
                                </div>
                            </div>
                            <div class="row">
                                <div class="column total">Total I.R.P.F. Descontado: ' . number_format((float)$total[$j], 2, ",", ".") . ' €
                            </div></div>
                            <div class="row">
                            <br><br>
                                <img src="img/sign.png" alt="Firma" style="width: 330px;">
                            </div>
                        </div>
                    <a id="image' . $j . '" download="Factura Nº ' . $id[$j] . '.png"></a>
                    <br><br>
                    <button onclick="pdfDown(' . $j . ')" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                    <br><br><br>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="printIt(' . $j . ')" style="width:160px; height:80px;" class="btn btn-primary">Imprime la Factura</button>
                        </div>
                        <div class="col-md-6">
                        <button onclick="window.open(\'saveIt.php?id=' . $id[$j] . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guarda la Factura en Exel</button>
                            <script>capture(' . $j . ');</script>
                        </div>
                    </div><br><br><br><br><br>';
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