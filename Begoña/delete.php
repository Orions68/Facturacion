<?php
include "includes/conn.php";
if (isset($_REQUEST["id"]))
{
    $id = $_REQUEST["id"];
    $sql = "DELETE FROM patients WHERE id=$id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $sql = "SET @count = 0; UPDATE patients SET id = @count:= @count + 1; ALTER TABLE patients AUTO_INCREMENT = 1;"; // Arreglo los índices de las facturas.
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<script>if (!alert('Datos Eliminados de la Base de Datos.')) window.open('index.php', '_self')</script>";
}
else
{
    echo "<script>if (!alert('Has Llegado Aquí por Error.')) window.oepn('index.php', '_self')</script>";
}
?>