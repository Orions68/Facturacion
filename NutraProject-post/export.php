<?php
include 'includes/conn.php';
include 'vendor/autoload.php';

	$date = $_POST['date']; // El Trimestre recibido desde admin.php.
	$year = $_POST['year']; // El Año recibido desde admin.php.
	$product = "";
	$price = "";
	$qtty = "";
	$letter = 0;
	
	switch($date)
	{
		case 1:
			$query = "SELECT *, DATE_FORMAT(inv_date,'%d %M %Y') date FROM invoice WHERE inv_date BETWEEN CAST('" . $year . "-01-01' AS DATE) AND CAST('" . $year . "-03-31' AS DATE) ORDER BY id;"; // Para el 1º Trimestre desde el 1/1 al 31/3
		break;
		case 2:
			$query = "SELECT *, DATE_FORMAT(inv_date,'%d %M %Y') date FROM invoice WHERE inv_date BETWEEN CAST('" . $year . "-04-01' AS DATE) AND CAST('" . $year . "-06-30' AS DATE) ORDER BY id;"; // Para el 2º Trimestre desde el 1/4 al 30/6
		break;
		case 3:
			$query = "SELECT *, DATE_FORMAT(inv_date,'%d %M %Y') date FROM invoice WHERE inv_date BETWEEN CAST('" . $year . "-07-01' AS DATE) AND CAST('" . $year . "-09-30' AS DATE) ORDER BY id;"; // Para el 3º Trimestre desde el 1/7 al 30/9
		break;
		default:
			$query = "SELECT *, DATE_FORMAT(inv_date,'%d %M %Y') date FROM invoice WHERE inv_date BETWEEN CAST('" . $year . "-10-01' AS DATE) AND CAST('" . $year . "-12-31' AS DATE) ORDER BY id;"; // Para el 4º Trimestre desde el 1/10 al 31/12
		break;
	}
	
	$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();
	
	$statement = $conn->prepare($query); // Preparo la consulta para obtener todos los datos de la tabla de facturas (invoice), del trimestre seleccionado..
	
	$statement->execute(); // Ejecuto la consulta.
	
	$result = $statement->fetchAll(); // Asigno todos los resultados a la variable $result.
	
if(isset($_POST["export"]))
{
	$file = new PhpOffice\PhpSpreadsheet\Spreadsheet(); // Hay que usarlo así en Wordpress, también funciona en cualquier script de PHP.

	$active_sheet = $file->getActiveSheet();

	$active_sheet->setCellValue('A1', 'Nº de factura');
	$active_sheet->setCellValue('B1', 'Cliente');
	$active_sheet->setCellValue('C1', 'Producto');
	$active_sheet->setCellValue('D1', 'Precio');
	$active_sheet->setCellValue('E1', 'Cantidad');
    $active_sheet->getStyle('E1')->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
	$active_sheet->setCellValue('F1', 'Hora');
	$active_sheet->setCellValue('G1', 'Día');
	$active_sheet->setCellValue('H1', 'Base Imponible');
	$active_sheet->setCellValue('I1', 'I.V.A.');
    $active_sheet->getStyle('I1')->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
	$active_sheet->setCellValue('J1', 'Total + I.V.A.');

	$count = 2;
	$total = 0;

	foreach($result as $row)
	{
		result($conn, $row, 0); // Llama a la fucnión result, le pasa la conexión, el resultado de la base de datos y un 0.
		
		$active_sheet->setCellValue('A' . $count, $row["id"]);
        $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
		$active_sheet->setCellValue('B' . $count, $name);
		$active_sheet->setCellValue('C' . $count, $product);
		$active_sheet->setCellValue('D' . $count, $price);
        $active_sheet->getStyle('D' . $count)->getAlignment()->setHorizontal("left"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
		$active_sheet->setCellValue('E' . $count, $qtty);
		$active_sheet->getStyle('E' . $count)->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
		$active_sheet->setCellValue('F' . $count, $row["time"]);
        $active_sheet->getStyle('F' . $count)->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
		$active_sheet->setCellValue('G' . $count, $row["date"]);
		$active_sheet->setCellValue('H' . $count, $row["total"] * 100 / 121);
		$active_sheet->getStyle('H' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
		$active_sheet->setCellValue('I' . $count, $row["iva"]);
		$active_sheet->getStyle('I' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
        $active_sheet->getStyle('I' . $count)->getAlignment()->setHorizontal("center"); // Alineación del texto con la cadena 'right', Alinea a la Derecha.
		$active_sheet->setCellValue('J' . $count, $row["total"]);
		$active_sheet->getStyle('J' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

		$count++;
		$product = "";
		$price = "";
		$qtty = "";
	}

	$active_sheet->setCellValue('I' . ($count + 2), "Total:");
	$active_sheet->setCellValue('J' . ($count + 2), "=SUM(J2:J" . ($count - 1) . ")");
	$active_sheet->getStyle('J' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A' . ($count + 4), "Nutra Project - N.I.F. 20-42000000-3");

	for ($i = 1; $i < $count; $i++)
    {
        $active_sheet->getRowDimension($i)->setRowHeight(50); // Cambia el tamaño Vertical de las filas usadas en la planilla.

        if ($i == 1)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getColumnDimension(chr(64 + $i))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 1))->setWidth(40); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 2))->setWidth(50); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 3))->setWidth(15); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 4))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 5))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 6))->setWidth(17.5);
            $active_sheet->getColumnDimension(chr(64 + $i + 7))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 8))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 9))->setWidth(16);
        }

        if ($i == $count - 1)
        {
            $active_sheet->getRowDimension($i + 3)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getRowDimension($i + 5)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
        }
    }
		
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST["file_type"]);

	$file_name = $date . 'º Trimestre de ' . $year . "." . $_POST["file_type"];

	$writer->save($file_name);

	header('Content-Type: application/x-www-form-urlencoded');

	header('Content-Transfer-Encoding: Binary');

	header("Content-disposition: attachment; filename=\"".$file_name."\"");

	readfile($file_name);

	unlink($file_name);

	exit;
}

$title = "Exportando Facturas";
include "includes/header.php";
?>
  	<img alt="logo" src="img/logo.webp" height="300" width="100%"/>
	<br>
    	<section class="container-fluid pt-3">
    		<br>
    		<h3 style="text-align: center;">Exporta las Facturas a Excel o CSV</h3>
    		<br>
          	<div class="row">
			  <div id="pc"></div>
				<div id="mobile"></div>
		  		<div class="col-md-1" style="width:3%;"></div>
            		<div class="col-md-10">
						<div class="row">
							<div class="col-md-7">
								Facturas:<?php echo " " . $date; ?>º Trimestre del año:<?php echo " " . $year; ?> Nutra Project - N.I.F. 20-42000000-3
							</div>
							<div class="col-md-2">
							<form method="post">
								<input type="hidden" name="date" value="<?php echo $date; ?>">
								<input type="hidden" name="year" value="<?php echo $year; ?>">
								<select name="file_type" class="form-control input-sm">
									<option value="Xlsx">Xlsx</option>
									<option value="Csv">Csv</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="submit" name="export" class="btn btn-primary btn-lg" value="Descarga el Informe" />
							</div>
						</div>
						</form>
						<br>
						<table>
							<tr>
							<th>Nº de factura</th>
							<th>Cliente</th>
							<th>Producto</th>
							<th>Precio</th>
							<th style="text-align: center;">Cantidad</th>
							<th>Hora</th>
							<th>Día</th>
							<th>Base Imponible</th>
							<th style="text-align: center;">I.V.A.</th>
							<th>Total + I.V.A.</th>
							</tr>
						<?php

						foreach($result as $row) // Este foreach se ejecuta primero, pone en el array $row todos los resultados obtenidos de la base de datos.
						{
							result($conn, $row, 1); // Llama a la fucnión result, le pasa la conexión, el resultado de la base de datos y un 1.

							echo '<tr>
							<td style="text-align: center;">' . $row["id"] . '</td>
							<td>' . $name . '</td>
							<td>' . $product . '</td>
							<td style="text-align: right;">' . $price . '</td>
							<td style="text-align: center;">' . $qtty . '</td>
							<td>' . $row["time"] . '</td>
							<td>' . $row["date"] . '</td>
							<td style="text-align: right;">' . number_format((float)$row["total"] * 100 / 121, 2, ',', '.') . ' €</td>
							<td style="text-align: center;">' . number_format((float)$row["total"] * 100 / 121 * .21, 2, ',', '.') . ' €</td>
							<td style="text-align: right;">' . number_format((float)$row["total"], 2, ',', '.') . ' €</td>
							</tr>';
							$product = "";
							$price = "";
							$qtty = "";
						}
						?>
					 </table>
					 <br><br>
					 <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
                     <br><br><br><br><br>
					</div>
				<div class="col-md-1" style="width:3%;"></div>
			</div>
    	</section>
<?php
include "includes/footer.html";

function result($conn, $row, $where) // Función result recibe la conexión, las filas de la base de datos $row y un 1 o un 0 para saber de donde se llama.
{
    global $name, $price, $product, $qtty;
    if ($row["client_id"] != null) // Si la ID del cliente no es null.
    {
        $client = $row["client_id"]; // Busco el nombre del cliente por la ID.
        $sql = "SELECT name FROM client WHERE id=$client";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row1 = $stmt->fetch(PDO::FETCH_OBJ);
        $name = $row1->name;
    }
    else // Si es null.
    {
        $name = "Consumidor Final"; // $name es Consumidor Final.
    }
    $productArray = explode(",", $row["product_id"]);
    $qttyArray = explode(",", $row["qtty"]);

    for ($i = 0; $i < count($productArray) - 1; $i++)
    {
        $sql_product = "SELECT product, price FROM product WHERE id=$productArray[$i]";
        $stmt = $conn->prepare($sql_product);
        $stmt->execute();
        $row_product = $stmt->fetch(PDO::FETCH_OBJ);
        $product_price = $row_product->product . "," . $row_product->price;
        $preproduct = explode(",", $product_price);
        if ($i == count($productArray) - 2)
        {
            $product .= $preproduct[0];
            $price .= number_format((float)$preproduct[1], 2, ',', '.') . " €";
            $qtty .= $qttyArray[$i];
        }
        else
        {
            if ($where == 1) // Si $where es 1, se llamo desde la tabla HTML.
            {
                $product .= $preproduct[0] . "<br>"; // Saltos de línea HTML.
                $price .= number_format((float)$preproduct[1], 2, ',', '.') . " €<br>";
                $qtty .= $qttyArray[$i] . "<br>";
            }
            else // Si no es 1 se llamo desde la plantilla de Excel.
            {
                $product .= $preproduct[0] . "\n"; // Saltos de línea \n.
                $price .= number_format((float)$preproduct[1], 2, ',', '.') . " €\n";
                $qtty .= $qttyArray[$i] . "\n";
            }
        }
    }
}
?>