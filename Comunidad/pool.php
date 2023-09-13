<?php
include "includes/conn.php";
$title = "Datos de la Piscina";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["ph"]))
{
    $pool = $_POST["pool"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $ph = $_POST["ph"];
    $mousse = $_POST["espuma"];
    $trans = $_POST["transparency"];
    $turbio = $_POST["turbia"];
    if ($turbio == "")
    {
        $turbio = NULL;
    }
    $clFree = $_POST["cl_libre"];
    $clComb = $_POST["cl_comby"];
    $tempAgua = $_POST["temp_agua"];
    if ($tempAgua == "")
    {
        $tempAgua = NULL;
    }
    $tempAmb = $_POST["temp_amb"];
    if ($tempAmb == "")
    {
        $tempAmb = NULL;
    }
    $humidity = $_POST["hum_relativa"];
    if ($humidity == "")
    {
        $humidity = NULL;
    }
    $co2 = $_POST["co2"];
    if ($co2 == "")
    {
        $co2 = NULL;
    }
    $control = $_POST["control"];
    if ($control == "")
    {
        $control = NULL;
    }
    $recirculacion = $_POST["recirculacion"];
    $observaciones = $_POST["obs"];
    if ($observaciones == "")
    {
        $observaciones = NULL;
    }

    $sql = "INSERT INTO piscina VALUES(:id_pool, :idc, :fecha, :hora, :espuma, :transparencia, :turbidez, :ph, :cl, :cldiff, :temp_agua, :temp_ambiente, :humedad, :co2, :recirculacion, :ctrl, :obs);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_pool' => NULL, ':idc' => $pool, ':fecha' => $date, ':hora' => $time, ':espuma' => $mousse, ':transparencia' => $trans, ':turbidez' => $turbio, ':ph' => $ph, ':cl' => $clFree, ':cldiff' => $clComb - $clFree, ':temp_agua' => $tempAgua, ':temp_ambiente' => $tempAmb, ':humedad' => $humidity, ':co2' => $co2, ':recirculacion' => $recirculacion, ':ctrl' => $control, ':obs' => $observaciones]);
    echo '<script>toast (0, "Datos Agregados:", "Se han agregado los Datos de los Valores del Agua de la Piscina.");</script>';
}
?>