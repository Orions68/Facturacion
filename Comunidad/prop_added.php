<?php
include "includes/conn.php";
$title = "Propietario Agregado";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["prop"]))
{
    $idc = $_POST["finca"];
    $name = $_POST["prop"];
    $surname1 = $_POST["surname1"];
    $surname2 = $_POST["surname2"];
    if ($surname2 == "")
    {
        $surname2 = NULL;
    }
    $apt = $_POST["apt"];
    $sql = "INSERT INTO propietario VALUES(:ID_owner, :idc, :name, :surname1, :surname2, :apartment);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ID_owner' => NULL, ':idc' => $idc, ':name' => $name, ':surname1' => $surname1, ':surname2' => $surname2, ':apartment' => $apt]);
    echo '<script>toast (0, "Propietario Agregado", "Se ha Agregado la Persona Propietaria de la Unidad: ' . $apt . '.");</script>';
}
?>