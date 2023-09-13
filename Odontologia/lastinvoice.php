<?php
include "includes/conn.php";
$title = "Última Factura";
include "includes/header.php";

$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
$stmt->execute();
$sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice ORDER BY id desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id = $row->id;
include "getName.php";
$patient = getName($conn, $row->patient_id, "P");
$doc = getName($conn, $row->doc_id, "D");
$desc = $row->description;
$total = $row->total;
$date = $row->date;
$time = $row->time;
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
					echo '<div id="printable0">
                            <h4>Clínica Odontológica - C.I.F. 42000000Q Calle X Nº 2, 38001, Santa Cruz de Tenerife</h4>
                            <h5>Factura Nº: ' . $id . ' a ' . $patient . " Fecha: " . $date . '</h5>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#c5c5c5;">Profesional
                                </div>
                                <div class="column left" style="background-color:#cacaca;">Trabajo
                                </div>
                                <div class="column middle" style="background-color:#d0d0d0;">Base Imponible Mano de Obra
                                </div>
                                <div class="column right" style="background-color:#d5d5d5;">I.G.I.C.
                                </div>
                                <div class="column moreright" style="background-color:#dadada;">Total + I.G.I.C.
                                </div>
                            </div>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#c5c5c5;">' . $doc . '
                                </div>
                                <div class="column left" style="background-color:#cacaca;">' . $desc . '
                                </div>
                                <div class="column middle" style="background-color:#d0d0d0;">' . number_format((float)$total, 2, ',', '.') . ' €
                                </div>
                                <div class="column right" style="background-color:#d5d5d5;">Exento
                                </div>
                                <div class="column moreright" style="background-color:#dadada;"> ' . number_format((float)$total, 2, ',', '.') . ' €
                                </div>
                            </div>
                            <div class="row">
                                <div class="column total">Total I.G.I.C. Incluido: ' . number_format((float)$total, 2, ",", ".") . ' €
                            </div></div>
                        </div>
                        <a id="image0" download="Factura Nº ' . $id . '.png"></a>
						<br><br>
						<button onclick="pdfDown(0)" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                        <br><br><br>
                        <div class="row">
                        <div class="col-md-4">
                        <button onclick="printIt(-1)" style="width:160px; height:80px;" class="btn btn-primary">Imprime la Factura</button>
                        </div>
                        <div class="col-md-6">
                        <button onclick="window.open(\'saveIt.php?id=' . $id . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guarda la Factura en Exel</button>
                        <script>capture(0);</script>
                        </div>
                        </div>';
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