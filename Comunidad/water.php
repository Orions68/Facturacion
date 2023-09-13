<?php
include "includes/conn.php";
$title = "Control del Consumo de Agua";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["owner"]))
{
    $id_owner = $_POST["owner"];
    $prop = "";
    $apt = "";
    $date = $_POST["fecha"];
    $cold = $_POST["cold"];
    $hot = $_POST["hot"];
    getOwner($conn, $id_owner);
    $sql = "INSERT into control_agua VALUES(:id_agua, :id_prop, :fecha, :pro, :propietario, :piso, :agua_fria, :agua_caliente);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_agua' => NULL, ':id_prop' => $id_owner, ':fecha' => $date, ':pro' => $apt, ':propietario' => $prop, ':piso' => $apt, ':agua_fria' => $cold, 'agua_caliente' => $hot]);
    echo '<script>toast (0, "Registros Agregados", "Se han Agregado los consumos de agua Fria y Caliente de: ' . $prop . ' Piso: ' . $apt . '");</script>';
}

function getOwner($conn, $id)
{
    global $prop, $apt;
    $sql = "SELECT * FROM propietario WHERE id_owner=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $prop = $row->name . " " . $row->surname1 . " " . $row->surname2;
        $apt = $row->apartment;
    }
}
?>