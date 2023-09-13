<?php
include "includes/conn.php";
$title = "Guardando la Factura";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div id="pc"></div>
    <div id="mobile"></div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
                <?php
                if (isset($_POST["doctor"]))
                {
                    $rep = "";
                    $rep_qtty = "";
                    $mat = "";
                    $mat_qtty = "";
                    $patient = $_POST["patient"];
                    $doc = $_POST["doctor"];
                    $qtty = $_POST["qtty"];
                    for ($i = 0; $i < $qtty; $i++)
                    {
                        if ($i == $qtty - 1)
                        {
                            $rep .= $_POST["rep" . $i];
                            $rep_qtty .= $_POST["qtty_rep" . $i];
                        }
                        else
                        {
                            $rep .= $_POST["rep" . $i] . ",";
                            $rep_qtty .= $_POST["qtty_rep" . $i] . ",";
                        }
                    }
                    $qtty2 = $_POST["qtty2"];
                    for ($i = 0; $i < $qtty2; $i++)
                    {
                        if ($i == $qtty2 - 1)
                        {
                            $mat .= $_POST["mat". $i];
                            $mat_qtty .= $_POST["qtty_mat" . $i];
                        }
                        else
                        {
                            $mat .= $_POST["mat". $i] . ",";
                            $mat_qtty .= $_POST["qtty_mat" . $i] . ",";
                        }
                    }
                    $desc = $_POST["service"];
                    $price = $_POST["price"];

                    echo "Factura al Paciente: " . $patient . " Atendido por: " . $doc . " Tratamiento: " . $desc . " se uso: " . $qtty . " Reemplazos: " . $rep . " en estas Cantidades: " . $rep_qtty . " y se Usaron los Siguientes Desechables: " . $mat . " en estas Cantidades: " . $mat_qtty . " Total a Pagar: " . $price;
                }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>