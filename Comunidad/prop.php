<?php
session_start();
$title = "Agregando Propietarios a la Camunidad";
include "includes/header.php";
include "includes/modal.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Agrega un Propietario a la Comunidad.</h1>
                    <br><br>
                    <fieldset>
                        <legend><h3>Introduce los Datos</h3></legend>
                        <br><br>
                        <form action="prop_added.php" method="post">
                            <input type="hidden" name="finca" value="<?php echo $_SESSION["finca"]; ?>">
                            <label><input type="text" name="prop"> Nombre del Propietario</label>
                            <br><br>
                            <label><input type="text" name="surname1"> Apellido 1</label>
                            <br><br>
                            <label><input type="text" name="surname2"> Apellido 2</label>
                            <br><br>
                            <label><input type="text" name="apt"> Apartamento</label>
                            <br><br>
                            <input type="submit" class="btn btn-primary btn-lg" value="Agrego este Propietario">
                        </form>
                    </fieldset>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>