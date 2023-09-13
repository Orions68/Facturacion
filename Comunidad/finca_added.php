<?php
include "includes/conn.php";
$title = "Comunidad Agregada";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["finca"]))
{
    $name = $_POST["finca"];
    $address = $_POST["address"];
    $cp = $_POST["cp"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $pool = $_POST["pool"];

    $sql = "INSERT INTO finca VALUES(:IDC, :name, :address, :cp, :city, :province, :pool);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':IDC' => NULL, ':name' => $name, ':address' => $address, ':cp' => $cp, ':city' => $city, ':province' => $province, ':pool' => $pool]);
    echo '<script>toast (0, "Comunidad Agregada", "Se ha agregado la Comunidad ' . $name . '.");</script>';
}
?>