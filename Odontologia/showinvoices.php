<?php
include "includes/conn.php";
include "getName.php";
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
            $patient[$i] = getName($conn, $row->patient_id, "P");
            $doc[$i] = getName($conn, $row->doc_id, "D");
            $desc[$i] = $row->description;
            $total[$i] = $row->total;
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
                    <h3>Clínica Odontológica - C.I.F. 42000000Q Calle X Nº 2, 38001, Santa Cruz de Tenerife</h3>
                        <h4>Factura  Nº: ' . $id[$j] . ', a ' . $patient[$j] . ' Fecha: ' . $date . '</h4>
                        <div class="row">
                            <div class="column left" style="background-color:#c5c5c5;">Profesional
                            </div>
                            <div class="column left" style="background-color:#cacaca;">&nbsp;
                            Trabajo
                            </div>
                            <div class="column middle" style="background-color:#d0d0d0;">
                            Base Imponible Mano de Obra
                            </div>
                            <div class="column right" style="background-color:#d5d5d5">
                            I.G.I.C.
                            </div>
                            <div class="column moreright" style="background-color:#dadada;">
                            Total + I.G.I.C.
                            </div>
                        </div>
                        <div class="row">
                            <div class="column left" style="background-color:#c5c5c5;">&nbsp;' . $doc[$j] . '
                            </div>
                            <div class="column left" style="background-color:#cacaca;">' . $desc[$j] . '
                            </div>
                            <div class="column middle" style="background-color:#d0d0d0;">' . number_format((float)$total[$j], 2, ',', '.') . ' €
                            </div>
                            <div class="column right" style="background-color:#d5d5d5;">Exento
                            </div>
                            <div class="column moreright" style="background-color:#dadada;">' . number_format((float)$total[$j], 2, ',', '.') . ' €
                            </div>
                        </div>
                        <div class="row">
                            <div class="column total">Total I.G.I.C. Incluido: ' . number_format((float)$total[$j], 2, ",", ".") . ' €</div>
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
                    </div><br><br>';
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