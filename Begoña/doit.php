<?php
include "includes/conn.php";
if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    $name = $_POST["patient"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $sql = "UPDATE patients SET name='$name', phone='$phone', email='$email' WHERE id=$id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<script>if (!alert('Datos Modificados en la Base de Datos.')) window.open('index.php', '_self')</script>";
}
else
{
    echo "<script>if (!alert('Has Llegado Aquí por Error.')) window.oepn('index.php', '_self')</script>";
}
?>