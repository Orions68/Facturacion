<?php
include "includes/conn.php";
$title = "Modificar o Eliminar Datos de una Persona";
include "includes/header.php";
include "includes/modal.html";

if (isset($_REQUEST["id"]))
{
    $id = $_REQUEST["id"];
    $sql = "SELECT * FROM patients WHERE id=$id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    $name = $row->name;
    $phone = $row->phone;
    $email = $row->email;

    echo "
    <section class='container-fluid pt-3'>
    <div class='row'>
        <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div id='view1' class='p-3'>
                    <br><br><br><br>
                    <form action='doit.php' method='post' target='_self'>
                    <label><input type='text' name='patient' value='" . $name . "' required> Nombre Completo</label>
                    <br><br>
                    <label><input type='text' name='phone' value='" . $phone . "'> Teléfono</label>
                    <br><br>
                    <label><input type='text' name='email' value='" . $email . "'> E-mail</label>
                    <br><br>
                    <input type='hidden' name='id' value='" . $id . "'>
                    <div class='row'>
                        <div class='col-md-3'>
                        <input type='submit' class='btn btn-primary btn-lg' value='Modifico los Datos'>
                        </div>
                    </form>
                        <div class='col-md-3'>
                        <input type='button' class='btn btn-danger btn-lg' onclick='window.open(\"delete.php?id=" . $id . "\", \"_self\")' value='Elimino los Datos'>
                        </div>
                    </div>
                </div>
            </div>
        <div class='col-sm-1'></div>
    </div>
    </section>
    ";
}
else
{
    echo "<script>toast(2, 'Error:', 'Has Llegado Aquí por Error.');</script>";
}
?>