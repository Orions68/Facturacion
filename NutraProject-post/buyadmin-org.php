<?php
// Script que usa el administrador para modificar precios y cantidades antes de facturar.
include "includes/conn.php";
$title = "Pedido Final - Antes de Pagar";
include "includes/header.php";
$j = 0; // $j se usa como índice correlativo de los array que voy rellenado con los valores que llegan por POST.

if (isset($_POST["invoice"])) // Si llego invoice
{
    $name = $_POST["username"]; // En $name guardo el $_POST["username"];
    $invoice = $_POST["invoice"]; // en $invoice guardo lo que llego en $_POST["invoice"], es una cadena de texto, con datos separados por ",".
    $array = explode(",", $invoice); // Exploto en $array la cadena invoice por la ",".
    for ($i = 0; $i < count($array) - 1; $i+=4) // Hago un bucle al tamaño de $array y le resto 1 ya que la cadena tiene una coma al final y el array cuenta un índice más, incremento $i en 4.
    {
        $id[$j] = $array[$i]; // Obtengo en $id[$j] lo que hay en el array en 0, 4, 8, etc.
        $product[$j] = $array[$i + 1]; // Obtengo en $product[$j] lo que hay en el array en 1, 5, 9, etc.
        $price[$j] = $array[$i + 2]; // Obtengo en $price[$j] lo que hay en el array en 2, 6, 10, etc.
        $qtty[$j] = $array[$i + 3]; // Obtengo en $qtty[$j] lo que hay en el array en 3, 7, 11, etc.
        $j++; // Incremento $j en 1.
    }
}
?>
<section>
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                <img alt="logo" src="img/logo.webp" height="300" width="100%"/>
                <br><br>
                    <h1>Pedido Final</h1>
                    <br><br>
                    <h3>Si Modificas Algún Precio se Recalculará la Factura.</h3>
                    <br><br>
                    <form action="invoice.php" method="post">
                        <?php
                        $total = 0;
                        echo "<script>var price = [];</script>"; // Creo la variable de javascript price y le asigno un array.
                        echo "<script>var qtty = [];</script>"; // Creo la variable de javascript qtty y le asigno un array.
                        for ($i = 0; $i < count($product); $i++) // Hago un bucle al tamaño del array $product.
                        {
                            echo "<script>price[" . $i . "] = " . $price[$i] . "</script>"; // Asigno a la variable de javascript price en la posición $i el contenido del array $price en $i.
                            echo "<script>qtty[" . $i . "] = " . $qtty[$i] . "</script>"; // Asigno a la variable de javascript qtty en la posición $i el contenido del array $qtty en $i.
                            $total += $price[$i] * $qtty[$i]; // Sumo los resultados de multiplicar el precio y la cantidad del prducto rcibido.
                            echo "<label>Producto: <input type='text' name='product" . $i . "' value='" . $product[$i] . "' style='width: 450px;' readonly></label>
                            <label><input id='price" . $i . "' type='number' name='price" . $i . "' value='" . number_format((float)$price[$i], 2, ',', '.') . "' min='0' onchange='calculate(this.id)' style='width: 128px;' step='any'> € Precio</label>
                            <label><input id='qtty" . $i . "' type='number' name='qtty" . $i . "' value='" . $qtty[$i] . "' min='1' onchange='calculate(this.id)' style='width: 64px;'> Cantidad</label>
                            <input type='hidden' name='id" . $i . "' value='" . $id[$i] . "'>
                            <input type='hidden' name='username' value='" . $name . "'>
                            <br><br>";
                            // El echo anterior muestra en pantalla un formulario que contiene producto precio y cantidad y se pueden modificar los valores, tanto precio como cantidad.
                        }
                        ?>
                        <input type="submit" class="btn btn-primary btn-lg" value="Factura Estos Productos">
                    </form>
                    <br><br>
                    <?php
                    echo "<label><input id='total' type='number' name='total' value='" . number_format((float)$total, 2, ',', '.') . "' readonly step='any'> € Total</label>
                    <br>
                    <label><input id='iva' type='number' name='iva' value='" . number_format((float)$total * .21, 2, ',', '.') . "' readonly step='any'> € I.V.A.</label>
                    <br>
                    <label><input id='totaliva' type='number' name='final' value='" . number_format((float)$total * .21 + $total, 2, ',', '.') . "' readonly step='any'> € Total más I.V.A.</label>
                    <br>";
                    // El echo anterior muestra los totales parciales, el iva y el total más iva a pagar.
                    ?>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>