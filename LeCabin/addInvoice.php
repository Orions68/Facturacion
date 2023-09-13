<?php
include "includes/conn.php";
$title = "Guardando la Factura";
include "includes/header.php";
include "includes/modal-invoice.html";

setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set("Europe/London");
$name = $_POST["username"];
$invoice = $_POST["invoice"];
$date = date("Y-m-d");
$time = date("H:i:s");
$total = 0;
$j = 0;
$record = explode (",", $invoice);

for ($i = 0; $i < count($record) - 3; $i+=4)
{
    $service_id[$j] = $record[$i];
    $price[$j] = $record[$i + 2];
    $qtty[$j] = $record[$i + 3];
    $total += $price[$j] * $qtty[$j];
    $j++;
}

$stmt = $conn->prepare('INSERT INTO invoice VALUES(:id, :client_id, :total, :inv_date, :inv_time);');
if (isset($_SESSION["client"]))
{
    $stmt->execute(array(':id' => null, ':client_id' => $_SESSION["client"], ':total' => $total, ':inv_date' => $date, ':inv_time' => $time));   
}
else
{
    $stmt->execute(array(':id' => null, ':client_id' => null, ':total' => $total, ':inv_date' => $date, ':inv_time' => $time));
}

$sql = "SELECT id FROM invoice ORDER BY id DESC LIMIT 1;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_OBJ);
$id = $row->id;
$sql = "INSERT INTO sold VALUES(:id, :invoice_id, :service_id, :qtty);";
$stmt = $conn->prepare($sql);
for ($i = 0; $i < count($qtty); $i++)
{
    $stmt->execute(array('id' => null, ':invoice_id' => $id, ':service_id' => $service_id[$i], ':qtty' => $qtty[$i]));
}

echo "<script>toast(0, 'Factura Agregada', 'La Factura de Monto: " . $total . " €, ha Sido Almacenada en la Base de Datos.');</script>";
include "includes/footer.html";
?>