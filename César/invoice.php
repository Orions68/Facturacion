<?php
include "inc/conn.php";
include "inc/modal-update.html";
$title = "Recibiendo los Datos de Facturación.";
include "inc/header.php";
if (isset($_POST["client"]))
{
    $client = $_POST["client"];
    if ($client == "")
    {
        $client = "Consumidor Final";
    }
    $job = $_POST["job"];
    $totaligic = $_POST["price"];
    // $price = $totaligic * 100 / 107;
    $date = $_POST["date"];
    $hour = $_POST["hour"];
    if ($hour <= 9)
    {
        $hour = "0" . $hour . ":";
    }
    else
    {
        $hour = $hour . ":";
    }
    $minutes = $_POST["minutes"];
    if ($minutes == 0)
    {
        $minutes = "00";
    }
    $minutes .= ":00";
    $time = $hour . $minutes;
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
                    if (!isset($_SESSION["input"]))
                    {
                        $_SESSION["input"] = true;
                        $sql = "INSERT INTO invoice VALUES(:id, :client, :job, :price, :totaligic, :date, :time)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array(':id' => null, ':client' => $client, ':job' => $job, ':price' => $totaligic, ':totaligic' => $totaligic, ':date' => $date, ':time' => $time));
                    }
                    echo "<script>toast(0, 'Factura a " . $client . "', ' De Monto " . $totaligic . " Agregada a la Base de Datos.');</script>";
					?>
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "inc/footer.html";
?>