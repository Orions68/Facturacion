<?php
// Script de prueba no se usa en el sitio.
include "includes/conn.php";
$title = "Pedido Final - Antes de Pagar";
include "includes/header.php";
$j = 0;
for ($i = 0; $i < count($_SESSION["car"]); $i+=3)
{
    $qtty[$j] = $_SESSION["car"][$i];
    $product[$j] = $_SESSION["car"][$i + 1];
    $price[$j] = $_SESSION["car"][$i + 2];
    $j++;
}
?>
<section>
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <h1>Pedido Final</h1>
                    <br><br>
                    <h3>Si Modificas Algún Precio se Recalculará la Factura.</h3>
                    <br><br>
                    <form action="pay.php" method="post">
                        <?php
                        $total = 0;
                        echo "<script>var price = [];</script>";
                        echo "<script>var qtty = [];</script>";
                        for ($i = 0; $i < count($product); $i++)
                        {
                            echo "<script>price[" . $i . "] = " . $price[$i] . "</script>";
                            echo "<script>qtty[" . $i . "] = " . $qtty[$i] . "</script>";
                            $total += $price[$i] * $qtty[$i];
                            echo "<label><input type='text' name='product' value='" . $product[$i] . "'> Producto</label>
                            <label><input id='price" . $i . "' type='number' name='price' value='" . $price[$i] . "' onchange='calculate(this.id)'> € Precio</label>
                            <label><input id='qtty" . $i . "' type='number' name='qtty' value='" . $qtty[$i] . "'> Cantidad</label>
                            <br><br>";
                        }
                        echo "<label><input id='total' type='number' name='total' value='" . $total . "'> € Total</label>
                            <br>
                            <label><input id='iva' type='number' name='iva' value='" . $total * .21 . "'> € I.V.A.</label>
                            <br>
                            <label><input id='totaliva' type='number' name='final' value='" . number_format((float)$total * .21 + $total, 2, ',', '.') . "'> € Total más I.V.A.</label>
                            <br>";
                        ?>
                        <input type="submit" value="Compro estos Productos">
                    </form>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<script>
    function calculate(id)
    {
        var res = id.charAt(id.length-1);
        let new_price = document.getElementById(id);
        let qtty_id = document.getElementById("qtty" + res);
        let total = document.getElementById("total");
        let iva = document.getElementById("iva");
        let totaliva = document.getElementById("totaliva");
        var last_price = new_price.value;
        console.log("El Precio rebajado es: " + last_price);
        var new_qtty = qtty_id.value;
        console.log("la cantidad nueva es: " + new_qtty);
        var org_price = price[res];
        console.log("El Precio original era: " + org_price);
        var org_qtty = qtty[res];
        console.log("La Cantidad original era: " + org_qtty);
        var pre_total = total.value;
        console.log("El Precio original era: " + pre_total);
        var pre_iva = iva.value;
        console.log("El iva original era: " + pre_iva);
        var pre_totaliva = totaliva.value;
        console.log("El Precio original con iva era: " + pre_totaliva);
        var final = pre_total - org_price * org_qtty + last_price * new_qtty + ((pre_total - org_price * org_qtty + last_price * new_qtty) * .21);
        console.log("Al final pagarás: " + final);
        iva.value = (pre_total - org_price * org_qtty + last_price * new_qtty) * .21;
        total.value = pre_total - org_price * org_qtty + last_price * new_qtty;
        totaliva.value = final.toFixed(2);
    }
</script>
</body>
</html>