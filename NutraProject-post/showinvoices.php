<?php
include "includes/conn.php";
$title = "Facturas por Días";
include "includes/header.php";
include "includes/modal.html";
include "includes/function.php";

?>
<section class="container-fluid pt-3">
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width:3%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <?php
            if (isset($_POST["date"]))
            {
                $date = $_POST["date"];
                echo "<h1>Facturas del Día: $date</h1>
                    <br><br>";
                $stmt_date = $conn->prepare("SET lc_time_names = 'es_ES'");
                $stmt_date->execute();
                $stmt = $conn->prepare("SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date='$date' ORDER BY date DESC, time DESC");
                $stmt->execute();
                if ($stmt->rowCount() > 0)
                {
                    $j = 0;
                    while($row = $stmt->fetch(PDO::FETCH_OBJ))
                    {
                        $id = $row->id;
                        $total = $row->total;
                        $client = getClient($conn, $row->client_id);
                        
                        echo '<div id="printable' . $j . '">
                            <h3><br>Nutra Project - A25000000-2 Calle Mollet del Valles, 08450 Barcelona</h3>
                            <br><h2>Factura Nº ' . $id . ' a: ' . $client . '</h2>
                            <h2>Fecha : ' . $row->date . ' - ' . $row->time . '</h2>
                            <div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#d6d6d6;">
                                <h3>Artículo</h3>
                                </div>
                                <div class="column right" style="background-color:#dbdbdb;">
                                <h3>Precio</h3>
                                </div>
                                <div class="column middle" style="background-color:#dfdfdf;">
                                <h4>Cantidad</h4>
                                </div>
                                <div class="column right" style="background-color:#e0e0e0;">
                                <h3>Parcial</h3>
                                </div>
                                <div class="column right" style="background-color:#e6e6e6;">
                                <h4>Base Imponible</h4>
                                </div>
                                <div class="column right" style="background-color:#ebebeb; text-align: center;">
                                <h4>I.V.A.</h4>
                                </div>
                                <div class="column right" style="background-color:#efefef;">
                                <h4>A Pagar de I.V.A.</h4>
                                </div>
                                <div class="column right" style="background-color:#efefef;">
                                <h4>Total a Pagar + I.V.A.</h4>
                                </div>
                            </div>';

                            result($conn, $row); // Llama a la función result, le pasa la conexión y el resultado de la base de datos.

                            echo '<div class="row">
                                <div style="width: 1px;"></div>
                                <div class="column left" style="background-color:#d6d6d6;">
                                <h5>' . $product . '</h5>
                                </div>
                                <div class="column right" style="background-color:#dbdbdb;">
                                <h5>' . $price . '</h5>
                                </div>
                                <div class="column middle" style="background-color:#dfdfdf;">
                                <h5>' . $qtty . '</h5>
                                </div>
                                <div class="column right" style="background-color:#e0e0e0;">
                                <h5>' . $partial . '</h5>
                                </div>
                                <div class="column right" style="background-color:#e6e6e6;">
                                <h5>' . number_format((float)$total * 100 / 121, 2, ",", ".") . ' €</h5>
                                </div>
                                <div class="column right" style="background-color:#ebebeb; text-align: center;">
                                <h5>21 %</h5>
                                </div>
                                <div class="column right" style="background-color:#efefef;">
                                <h5>' . number_format((float)$total * .21, 2, ",", ".") . ' €</h5>
                                </div>
                                <div class="column right" style="background-color:#efefef;">
                                <h5>' . number_format((float)$total, 2, ",", ".") . ' €</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column total">Total I.V.A. Incluido: ' . number_format((float)$total, 2, ",", ".") . ' €
                            </div></div>
                        </div>
                        <a id="image' . $j . '" download="Factura a: ' . $client . '.png"></a>
                        <br><br><br><br>
                        <div class="row">
                            <div class="col-md-4">
                            <button onclick="printIt(' . $j . ')" style="width:160px; height:80px;" class="btn btn-primary">Imprimir Ticket</button>
                            </div>
                            <div class="col-md-5">
                            <button onclick="pdfDown(' . $j . ')" class="btn btn-secondary btn-lg">Descarga la Factura en PDF</button>
                            </div>
                            <div class="col-md-3">
                            <button onclick="window.open(\'saveIt.php?id=' . $id . '\', \'_blank\')" style="width:160px; height:80px;" class="btn btn-info">Guardar Factura en Excel</button>
                            <script>capture(' . $j . ');</script>
                            </div>
                        </div>
                                <br><br>';
                                $product = "";
                                $price = "";
                                $qtty = "";
                                $partial = "";
                        echo '<br><br><br><br>';
                        $j++;
                    }
                }
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