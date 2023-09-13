<?php
include "inc/conn.php";
$title = "Última Factura";
include "inc/header.php";

$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
$stmt->execute();
$sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice ORDER BY id desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id = $row->id;
$client = $row->client;
$job = $row->job;
$price = $row->price;
$totaligic = $row->totaligic;
$date = $row->date;
$time = $row->time;
?>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width: 3%;"></div>
            <div class="col-md-10">
                <div id="view1">
					<br><br>
					<?php
					echo '<div id="printable0">
                            <h4>César Osvaldo Matelat Borneo - 42268151Q Calle Fermín Morín Nº 2, 38007, Santa Cruz de Tenerife</h4>
                            <h5>Factura Nº: ' . $id . ' a ' . $client . " Fecha: " . $date . '</h5>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#ccc;">Trabajo
                                </div>
                                <div class="column middle" style="background-color:#ddd;">Base Imponible Mano de Obra
                                </div>
                                <div class="column right" style="background-color:#dde;">I.G.I.C.
                                </div>
                                <div class="column moreright" style="background-color:#eee;">Total + I.G.I.C.
                                </div>
                            </div>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#ccc;">' . $job . '
                                </div>
                                <div class="column middle" style="background-color:#ddd;">' . number_format((float)$price, 2, ',', '.') . ' €
                                </div>
                                <div class="column right" style="background-color:#dde;">Exento
                                </div>
                                <div class="column moreright" style="background-color:#eee;"> ' . number_format((float)$totaligic, 2, ',', '.') . ' €
                                </div>
                            </div>
                            <div class="row">
                                <div class="column total">Total I.G.I.C. Incluido: ' . number_format((float)$totaligic, 2, ",", ".") . ' €
                            </div></div>
                        </div>
                        <a id="image0" download="Factura Nº ' . $id . '.png"></a>
                        <br><br><br><br>
                        <div class="row">
                        <div class="col-md-4">
                        <button onclick="printIt(-1)" style="width:160px; height:80px;" class="btn btn-primary">Imprime la Factura</button>
                        </div>
                        <div class="col-md-5">
                        <button onclick="pdfDown(0)" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                        </div>
                        <div class="col-md-3">
                        <button onclick="window.open(\'saveIt.php?id=' . $id . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guarda la Factura en Exel</button>
                        <script>capture(0);</script>
                        </div>
                        </div>';
					?>
                    <br><br><br><br>
                    <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "inc/footer.html";
?>