<?php
include "includes/conn.php";
$title = "Empleado Agregado";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["employee"]))
{
    $idc = $_POST["idc"];
    $name = $_POST["employee"];
    $surname1 = $_POST["surname1"];
    $surname2 = $_POST["surname2"];
    if ($surname2 == "")
    {
        $surname2 = NULL;
    }
    $dni = $_POST["dni"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $iban = $_POST["iban"];
    $contract = $_POST["contract"];
    $alta = $_POST["alta"];

    $sql = "INSERT INTO empleado VALUES(:ID, :idc, :name, :surname1, :surname2, :dni, :phone, :email, :address, :iban, :contract, :alta, :vacation_in, :vacation_out);";
    $stmt = $conn->prepare($sql);
    // $stmt->execute(array(':ID' => NULL, ':idc' => $idc ':name' => $name, ':surname1' => $surname1, ':surname2' => $surname2, ':dni' => $dni, ':phone' => $phone, ':email' => $email, ':address' => $address, ':iban' => $iban, ':contract' => $contract, ':vacation_in' => NULL, ':vacation_out' => NULL));
    $stmt->execute([':ID' => NULL, ':idc' => $idc, ':name' => $name, ':surname1' => $surname1, ':surname2' => $surname2, ':dni' => $dni, ':phone' => $phone, ':email' => $email, ':address' => $address, ':iban' => $iban, ':contract' => $contract, ':alta' => $alta, ':vacation_in' => NULL, ':vacation_out' => NULL]);
    echo '<script>toast (0, "Empleado Agregado", "Se ha agregado el Empleado ' . $name . ' ' . $surname1 . ' con contrato: ' . $contract . '.");</script>';
}
?>