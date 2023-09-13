<?php
session_start();
session_destroy();
$title = "Agregando una Nueva Comunidad";
include "includes/header.php";
include "includes/modal.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Agrega una Nueva Comunidad.</h1>
                    <br><br>
                    <fieldset>
                        <legend><h3>Introduce los Datos</h3></legend>
                        <br><br>
                        <form action="finca_added.php" method="post">
                            <label><input type="text" name="finca"> Nombre de la Comunidad</label>
                            <br><br>
                            <label><input type="text" name="address"> Dirección</label>
                            <br><br>
                            <label><input type="text" name="cp"> Código Postal</label>
                            <br><br>
                            <label><input type="text" name="city"> Ciudad</label>
                            <br><br>
                            <label><input type="text" name="province"> Provincia</label>
                            <br><br>
                            <label><input type="radio" name="pool" value="1" checked> SÍ Tiene Piscina</label>
                            <br><br>
                            <label><input type="radio" name="pool" value="0"> No Tiene Piscina</label>
                            <br><br>
                            <input type="submit" class="btn btn-primary btn-lg" value="Agrego esta Comunidad">
                        </form>
                    </fieldset>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>