<?php
include "includes/conn.php";
$title = "Modificando Datos de Empleado";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["employee"]) || isset($_POST["employee1"]))
{
    switch ($_POST)
    {
        case isset($_POST['borrar']):
            $name = $_POST["employee"];
            $surname = $_POST["surname"];
            echo $name . " " . $surname . " Estoy en Borrar.";
            break;
        case isset($_POST['borrar1']):
            $id = $_POST["id1"];
            $name = $_POST["employee1"];
            $surname = $_POST["surname1"];
            echo $name . " " . $surname . " Estoy en Borrar1.";
            $sql = "DELETE FROM empleado WHERE ID=$id;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $sql = "SET @count = 0; UPDATE empleado SET id = @count:= @count + 1; ALTER TABLE empleado AUTO_INCREMENT = 1;"; // Arreglo los índices de las facturas.
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            break;
        case isset($_POST['baja']):
            $name = $_POST["employee"];
            $surname = $_POST["surname"];
            echo $name . " " . $surname . " Estoy en Baja.";
            break;
        case isset($_POST['baja1']):
            $name = $_POST["employee1"];
            $surname = $_POST["surname1"];
            echo $name . " " . $surname . " Estoy en Baja1.";
            break;
        case isset($_POST['modify']):
            $name = $_POST["employee"];
            $surname = $_POST["surname"];
            echo $name . " " . $surname . " Estoy en Modify.";
            break;
        case isset($_POST['modify1']):
            $name = $_POST["employee1"];
            $surname = $_POST["surname1"];
            echo $name . " " . $surname . " Estoy en Modify1.";
            break;
    }
}
?>