<?php
include "includes/conn.php";
$title = "Factura Agregada a la Base de Datos";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["patient"]))
{
    $date = Date("Y-m-d");
    $time = Date("h:i:sa");
    $patient = $_POST["patient"];
    $id = explode(",", $patient);
    $desc = $_POST["desc"];
    $qtty = $_POST["qtty"];
    $price = $_POST["price"];

    $irpf = $price * $qtty * .15;
    $total = $price * $qtty - $irpf;
	if (!isset($_SESSION["input"]))
	{
		$_SESSION["input"] = 0;
		$sql = "INSERT INTO invoice VALUES(:id, :pat_id, :concept, :qtty, :partial, :total, :date, :time);";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':id' => null, ':pat_id' => $id[0], ':concept' => $desc, ':qtty' => $qtty, ':partial' => $price, ':total' => $total, ':date' => $date, ':time' => $time));
	}
    echo "<script>toast(0, 'Factura Agregada', 'La Factura de Monto: $total € se ha Agregado a la Base de Datos.');</script>";
}
?>