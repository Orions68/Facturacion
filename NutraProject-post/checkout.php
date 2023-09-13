<?php
include "includes/conn.php";

if (isset($_POST["id0"])) // Si se recibió al menos una compra.
{
    $size = (count($_POST)) / 4; // Asigno a la variable $size el tamaño de lo que llega por POST dividido 4 ya que son cuatro datos por producto.

    for ($i = 0; $i < $size; $i++) // Hago un bulce hasta el tamaño de los datos recibidos.
    {
        $id[$i] = $_POST["id" . $i]; // Asigno a la variable $id[$i] el valor de $_POST["id0"], la ID del evento.
        $product[$i] = $_POST["product" . $i]; // El nombre del producto.
        $price[$i] = $_POST["price" . $i]; // El precio del producto.
        $qtty[$i] = $_POST["qtty" . $i]; // La cantidad de unidades.
        $total[$i] = $price[$i] * $qtty[$i]; // Calculo el total a pagar mutiplicando la cantidad de entradas compradas por el precio, para cada evento.
    }
}
else
{
    echo "<script>if (!alert('Nada, has llegado aquí por error.')) window.open('index.php');</script>"; // Si entras sin datos, error.
}
$title = "Por Fin Tengo Mis Suplementos"; // Título de la página.
include "includes/header.php";

?>
<section class='container-fluid pt-3'>
    <div class='row'>
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div id="view1">
                    <br><br><br><br>
                    <h1>Preparando tu Pedido</h1>
                    <br>
                    <h3>Esta y Todas tus Facturas estarán disponibles en tu Perfil de Ususario. Solo para Usuarios Registrados.</h3>
                    <br><br>
                    <h2>Tu Pedido:</h2>
                    <br><br>
                    <?php
                    for ($i = 0; $i < $size; $i++)
                    {
                        echo "<h3>$product[$i], $price[$i], $qtty[$i]<br></h3>";
                    }
                    ?>
                    <br><br>
                    <div class="row">
                        <div class="col-md-6">
                    <button onclick="window.open('endsession.php', '_self')">Salir y Cerrar la Sesión de Compra</button>
                    </div>
                    <div class="col-md-6">
                    <button onclick="window.open('index.php', '_self')">Volver y Seguir Comprando</button>
                    </div>
                    </div>
                </div>
            </div>
        <div class='col-sm-1'></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>