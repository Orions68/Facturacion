<?php
$title = "Página Principal";
include "includes/header.php";
?>
    <section class="container-fluid pt-3">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Selecciona la Habitación del Desplegable</h1>
                    <br>
                    <form action="check.php" method="post">
                        <label><input type="date" name="datein"> Selecciona la Fecha de Entrada</label>
                        <br><br>
                        <label><input type="date" name="dateout"> Selecciona la Fecha de Salida</label>
                        <br><br>
                        <input type="submit" value="Habitaciones Disponibles">
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
<?php
include "includes/footer.html";
?>