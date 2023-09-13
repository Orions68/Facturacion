<?php
$title = "Agregando un Empleado";
include "includes/header.php";
include "includes/modal.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Agrega un Nuevo Empleado.</h1>
                    <br><br>
                    <fieldset>
                        <legend><h3>Introduce los Datos</h3></legend>
                        <br><br>
                        <form action="added.php" method="post">
                            <?php
                            if (isset($_GET["idc"]))
                            {
                                $idc = $_GET["idc"];
                                echo '<input type="hidden" name="idc" value="' . $idc . '">';
                            }
                            ?>
                            <label><input type="text" name="employee"> Nombre</label>
                            <br><br>
                            <label><input type="text" name="surname1"> Apellido 1</label>
                            <br><br>
                            <label><input type="text" name="surname2"> Apellido 2</label>
                            <br><br>
                            <label><input type="text" name="dni"> D.N.I.</label>
                            <br><br>
                            <label><input type="text" name="phone"> Teléfono</label>
                            <br><br>
                            <label><input type="text" name="email"> E-mail</label>
                            <br><br>
                            <label><input type="text" name="address"> Dirección</label>
                            <br><br>
                            <label><input type="text" name="iban"> IBAN</label>
                            <br><br>
                            <label><select name="contract">
                                <option value="">Selecciona el tipo de Contrato para este Empleado.</option>
                                <option value="Indefinido">Indefinido</option>
                                <option value="Sustitución">Sustitución</option>
                            </select> Tipo de Contrato</label>
                            <br><br>
                            <label><input type="radio" name="alta" value="1" checked> SÍ Dado de alta</label>
                            <br><br>
                            <label><input type="radio" name="alta" value="0"> No Dado de alta</label>
                            <br><br>
                            <input type="submit" class="btn btn-primary btn-lg" value="Agrego este Empleado">
                        </form>
                    </fieldset>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>