<?php
include "includes/conn.php";
$title = "Página de Registro de Pacientes";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["client"]))
{
    $client = $_POST["client"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $sql = "INSERT INTO patients VALUES (:id, :name, :phone, :email);";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':id' => null, ':name' => $client, ':phone' => $phone, ':email' => $email));
    echo "<script>toast(0, 'Persona Agregada', 'La Persona con nombre: $client se ha Agregado para Facturar.');</script>";
}
?>