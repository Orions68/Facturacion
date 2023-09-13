<?php
$title = "Principal";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
                    <h1>Inputs en Javascript</h1>
                    <br><br>
                    <h3>Selecciona la cantidad de Inputs a Crear:</h3>
                    <br><br>
                    <form action="save.php" method="post">
                        <label><input type="number" name="hand"> Mano de Obra</label>
                        <br><br>
                        <input id="num" type="number">
                        <input type="button" onclick="moreFields(document.getElementById('num').value)" value="Agrega esta Cantidad de Materiales." class="btn btn-secondary btn-lg">
                        <div id="container"></div>
                        <br><br>
                        <input type="submit" value="Facturo Esto" class="btn btn-primary btn-lg">
                    </form>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>