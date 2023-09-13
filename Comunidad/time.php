<?php
if (isset($_POST["morn_in"]))
{
    include "includes/conn.php";
    echo $_POST["morn_in"];
    $morn_in = $_POST["morn_in"];
    list($hours, $minutes) = explode(':', $morn_in, 2);
    $seconds_1 = $minutes * 60 + $hours * 3600;
    $morn_out = $_POST["morn_out"];
    list($hours, $minutes) = explode(':', $morn_out, 2);
    $seconds_2 = $minutes * 60 + $hours * 3600;
    $noon_in = $_POST["noon_in"];
    list($hours, $minutes) = explode(':', $noon_in, 2);
    $seconds_3 = $minutes * 60 + $hours * 3600;
    $noon_out = $_POST["noon_out"];
    list($hours, $minutes) = explode(':', $noon_out, 2);
    $seconds_4 = $minutes * 60 + $hours * 3600;
    $today = date("Y-m-d");
    $total = ($seconds_2 - $seconds_1 + $seconds_4 - $seconds_3) / 3600;
    $id = $_POST["id"];

    $sql = "INSERT INTO horario VALUES(:id_time, :id_empleado, :fecha, :morn_in, :morn_out, :noon_in, :noon_out, :total_horas);";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':id_time' => NULL, ':id_empleado' => $id, ':fecha' => $today, ':morn_in' => $morn_in, ':morn_out' => $morn_out, ':noon_in' => $noon_in, ':noon_out' => $noon_out, ':total_horas' => $total));
}
?>