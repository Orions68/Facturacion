<?php
include "includes/conn.php";
$title = "Nutra Project - Descripción de Productos";
include "includes/header.php";
include "includes/nav-index.html";
include "includes/nav-mob-index.html";
include "includes/modal.html";

if (isset($_GET["id"])) // Recibo desde index.php la ID del artículo que seleccioné, también llega la ID del artículo que quito del carro y se vuelve a mostrar en la página el artículo quitado.
{
    $id = $_GET["id"];
    $sql = "SELECT * FROM product WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    echo '
    <section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br>
                <div class="row">
                    <div class="col-md-6">
                    <h1>Has Seleccionado: ' . $row->product . '</h1>
                    <br>
                    <img class="productimg" src="' . $row->img . '" alt="' . $row->product . '">
                    <h3>Precio: ' . $row->price . ' €</h3>
                    <br><br>
                    
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                    <br><br><br><br><br>
                    <h5>' . $row->description . '</h5>
                    <br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    </section>';
}
else
{
    echo "<h1>Has llegado aquí por Error.</h1>";
}
echo "<br><br>";
?>
<br>
<?php
include "includes/footer.html";
?>