<?php
include "includes/conn.php";
include "includes/modal-update.html";
$title = "Facturación de Fernando";
include "includes/header.php";
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set("Europe/London");
if (isset($_POST["job"]))
{
    $material = "";
    $price = "";
    $prices = 0;
    $client = $_POST["client"];
    if ($client == "")
    {
        $client = "Consumidor Final";
    }
    $job = $_POST["job"];
    for ($i = 0; $i < (count($_POST) - 6) / 2; $i++)
    {
        $material .= $_POST["material" . $i] . ", ";
        $price .= $_POST["price" . $i] . ", ";
    }
    $price_array = explode(",", $price);
    for ($i = 0; $i < count($price_array) - 1; $i++)
    {
        $prices += $price_array[$i];
    }
    $hand = $_POST["hand"];
    $date = $_POST["date"];
    $total = $hand + $prices;
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
                    $sql = "INSERT INTO invoice VALUES(:id, :client, :job, :hand, :total, :date);";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array(':id' => null, ':client' => $client, ':job' => $job, ':hand' => $hand, ':total' => $total, ':date' => $date));
                    echo "<script>toast(0, 'Factura a " . $client . "', ' De Monto " . $total . " Agregada a la Base de Datos.');</script>";
					?>
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>