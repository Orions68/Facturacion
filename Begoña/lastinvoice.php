<?php
include "includes/conn.php";
include "includes/client.php";
$title = "Última Factura";
include "includes/header.php";
include "includes/modal.html";

$ok = false;
$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
$stmt->execute();
$sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice ORDER BY id desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() > 0)
{
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    $id = $row->id;
    $pat_id = $row->pat_id;
    $patient = getClient($conn, $pat_id);
    $job = $row->concept;
    $qtty = $row->qtty;
    $price = $row->partial;
    $total = $row->total;
    $irpf = $price * $qtty - $total;
    $date = $row->date;
    $time = $row->time;
    $ok = true;
}
else
{
    echo "<script>toast(1, 'Aun sin Datos', 'No se ha Hecho Ninguna Factura Hasta Ahora.');</script>"; // No hay Facturas.
}
?>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
					<br><br>
					<?php
                    if ($ok)
                    {
					echo '<div id="printable0">
                    <div class="row">
                    <div class="col-md-2">
                            <h4>Factura Nº: ' . $id . '<br>a: ' . $patient . "<br>Fecha: " . $date . '</h4>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="img/tree.png" alt="Logo del Grupo Tagor">
                            <h3>Grupo Tagor</h3>
                            <h4>Begoña Moreno Megias - 42021197-J<br>C/. Juan Padrón núm. 11, 1º izq.<br> 38003 SANTA CRUZ DE TENERIFE<br>Te: 630738642<br>E-mail: bmorenomegias@gmail.com</h4>
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
                                <div class="column left" style="background-color:#e0e0e0;">' . $job . '
                                </div>
                                <div class="column right" style="background-color:#e5e5e5;">' . $qtty . '
                                </div>
                                <div class="column middle" style="background-color:#eaeaea;">' . number_format((float)$price * $qtty, 2, ',', '.') . ' €
                                </div>
                                <div class="column right" style="background-color:#f0f0f0;">' . number_format((float)$irpf, 2, ',', '.') . ' €
                                </div>
                                <div class="column moreright" style="background-color:#f5f5f5;"> ' . number_format((float)$price * $qtty, 2, ',', '.') . ' € - ' . number_format((float)$irpf, 2, ',', '.') . ' €
                                </div>
                            </div>
                            <div class="row">
                                <div class="column total">Total I.R.P.F. Descontado: ' . number_format((float)$total, 2, ",", ".") . ' €
                            </div></div>
                            <div class="row">
                            <br><br>
                                <img src="img/sign.png" alt="Firma" style="width: 330px;">
                            </div>
                        </div>
                        <a id="image0" download="Factura Nº ' . $id . ' a: ' . $patient . '.png"></a>
                        <br><br>
                        <button onclick="pdfDown(0)" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                        <br><br><br>
                        <div class="row">
                        <div class="col-md-4">
                        <button onclick="printIt(-1)" style="width:160px; height:80px;" class="btn btn-primary">Imprime La Factura</button>
                        </div>
                        <div class="col-md-6">
                        <button onclick="window.open(\'saveIt.php?id=' . $id . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guarda la Factura en Exel</button>
                        <script>capture(0);</script>
                        </div>
                        </div>';
                    }
					?>
                    <br><br>
                    <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
                    <br><br><br><br><br>
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>