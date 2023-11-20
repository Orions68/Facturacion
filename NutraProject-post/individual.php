<?php
include "includes/conn.php";
$title = "Facturas por Días";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["date"]))
{
    $date = $_POST["date"];
    $mydate = explode("-", $date);
    $mdate = $mydate[2] . "/" . $mydate[1] . "/" . $mydate[0];
    $product = "";
	$price = "";
	$qtty = "";

    $stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();

    $sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date='$date'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>
<section class="container-fluid pt-3">
    <div class="row">
    <div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width:3%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <img alt="logo" src="img/logo.webp" height="300" width="100%"/>
                <br><br>
                <h3 style="text-align: center;">Facturas del Día <?php echo $mdate; ?></h3>
                <br>
                <table>
                    <tr>
                    <th>Nº de factura</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Día</th>
                    <th>Base Imponible</th>
                    <th>Total + I.V.A.</th>
                    <th>Forma de Pago</th>
                    <th style="color: red;">BORRAR</th>
                    </tr>
                    
<?php
    foreach($result as $row)
	{
        if ($row["client_id"] != null)
        {
            $client = $row["client_id"];
            $sql = "SELECT name FROM client WHERE id=$client";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row1 = $stmt->fetch(PDO::FETCH_OBJ);
            $name = $row1->name;
        }
        else
        {
            $name = "Consumidor Final";
        }
        $way = $row["way"];

        $sql = 'SELECT * FROM sold WHERE invoice_id=$row["id"];';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            $index = 0;
            while ($stmt->fetch(PDO::FETCH_OBJ))
            {
                $productArray[$index] = $row->product_id;
                $qttyArray[$index] = $row->qtty;
                $index++;
            }
        }

        for ($i = 0; $i < count($productArray); $i++)
        {
            $product_price = getProduct($conn, $productArray[$i]);
            $preproduct = explode(",", $product_price);
            if ($i == count($productArray) - 2)
            {
                $product .= $preproduct[0];
                $price .= number_format((float)$preproduct[1], 2, ',', '.') . " €";
                $qtty .= $qttyArray[$i];
            }
            else
            {
                $product .= $preproduct[0] . "<br>";
                $price .= number_format((float)$preproduct[1], 2, ',', '.') . " €<br>";
                $qtty .= $qttyArray[$i] . "<br>";
            }
        }

        echo '<tr>
        <td>' . $row["id"] . '</td>
        <td>' . $name . '</td>
        <td>' . $product . '</td>
        <td>' . $price . '</td>
        <td>' . $qtty . '</td>
        <td>' . $row["date"] . '</td>
        <td>' . number_format((float)$row["total"] * 100 / 121, 2, ',', '.') . ' €</td>
        <td>' . number_format((float)$row["total"], 2, ',', '.') . ' €</td>
        <td>' . $way . '</td>
        <td><form action="delete.php" method="post">
            <input type="hidden" name="id" value="' . $row["id"] . '">
            <input type="submit" value="Quitar" class="btn btn-danger">
            </form>
        </td>
        </tr>';
        $product = "";
		$price = "";
		$qtty = "";
	}
    ?>
                    </table>
                        </div>
                    </div>
                <div class="col-md-1" style="width:3%;"></div>
            </div>
        </section>
        <br>
        <br>
	    <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
        <br><br><br><br><br>
<?php
}
include "includes/footer.html";

function getProduct($conn, $product_id)
{
    $sql_product = "SELECT product, price FROM product WHERE id=$product_id";
    $stmt = $conn->prepare($sql_product);
    $stmt->execute();
    $row_product = $stmt->fetch(PDO::FETCH_OBJ);
    return $row_product->product . "," . $row_product->price;
}
?>