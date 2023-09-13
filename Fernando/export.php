<?php
include 'includes/conn.php';
include 'vendor/autoload.php';

	$date = $_POST['date']; // El Trimestre recibido desde admin.php.
	$year = $_POST['year']; // El Año recibido desde admin.php.
	$service = "";
	$replacement = "";
	
	switch($date)
	{
		case 1:
			$query = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date BETWEEN CAST('" . $year . "-01-01' AS DATE) AND CAST('" . $year . "-03-31' AS DATE) ORDER BY id ASC"; // Para el 1º Trimestre desde el 1/1 al 31/3
		break;
		case 2:
			$query = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date BETWEEN CAST('" . $year . "-04-01' AS DATE) AND CAST('" . $year . "-06-30' AS DATE) ORDER BY id ASC"; // Para el 2º Trimestre desde el 1/4 al 30/6
		break;
		case 3:
			$query = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date BETWEEN CAST('" . $year . "-07-01' AS DATE) AND CAST('" . $year . "-09-30' AS DATE) ORDER BY id ASC"; // Para el 3º Trimestre desde el 1/7 al 30/9
		break;
		case 4:
			$query = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE date BETWEEN CAST('" . $year . "-10-01' AS DATE) AND CAST('" . $year . "-12-31' AS DATE) ORDER BY id ASC"; // Para el 4º Trimestre desde el 1/10 al 31/12
		break;
	}
	
	$stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();
	
	$statement = $conn->prepare($query);
	
	$statement->execute();
	
	$result = $statement->fetchAll();
	
if(isset($_POST["export"]))
{
	$file = new PhpOffice\PhpSpreadsheet\Spreadsheet();

	$active_sheet = $file->getActiveSheet();

	$active_sheet->setCellValue('A1', 'Nº de factura');
	$active_sheet->setCellValue('B1', 'Cliente');
	$active_sheet->setCellValue('C1', 'Servicio');
    $active_sheet->setCellValue('D1', 'Mano de Obra');
	$active_sheet->setCellValue('E1', 'Día');
	$active_sheet->setCellValue('F1', 'Total');

	$count = 2;
	$total = 0;

	foreach($result as $row)
	{
        $id = $row["id"];
        $client = $row["client"];
        $service = $row["job"];
        $hand = $row["hand"];
        $total = $row["total"];
        $mydate = $row["date"];

		$active_sheet->setCellValue('A' . $count, $id);
        $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal("left");
		$active_sheet->setCellValue('B' . $count, $client);
		$active_sheet->setCellValue('C' . $count, $service);
        $active_sheet->setCellValue('D' . $count, $hand);
        $active_sheet->getStyle('D' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
        $active_sheet->setCellValue('E' . $count, $mydate);
        $active_sheet->getStyle('E' . $count)->getAlignment()->setHorizontal("right");
		$active_sheet->setCellValue('F' . $count, $total);
		$active_sheet->getStyle('F' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

		$count++;
	}

	$active_sheet->setCellValue('E' . ($count + 2), "Total:");
	$active_sheet->setCellValue('F' . ($count + 2), "=SUM(F2:F" . ($count - 1) . ")");
	$active_sheet->getStyle('F' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A' . ($count + 4), "Fernando Ariel Filippelli - Y0575228N Camino La Unión 31 38270 Valle de Guerra");

	for ($i = 1; $i < $count; $i++)
    {
        $active_sheet->getRowDimension($i)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.

        if ($i == 1)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getColumnDimension(chr(64 + $i))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 1))->setWidth(40); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 2))->setWidth(57); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 3))->setWidth(15); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 4))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 5))->setWidth(15);
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
<section class="container-fluid pt-3">
<div id="pc"></div>
	<div id="mobile"></div>
    <br>
    <h3 style="text-align: center;">Exporta las Facturas a Excel o CSV</h3>
    <br>
    <div class="row">
        <div class="col-md-1" style="width:3%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <div class="row">
                    <div class="col-md-7">
                        Facturas: <?php echo " " . $date; ?>º Trimestre del año: <?php echo " " . $year; ?> Fernando Ariel Filippelli - Y0575228N Camino La Unión 31 38270 Valle de Guerra
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
                        <th>Servicio</th>
                        <th>Mano de Obra</th>
                        <th>Total</th>
                        <th>Día</th>
                    </tr>
                <?php

                foreach($result as $row)
                {
                    $id = $row["id"];
                    $client = $row["client"];
                    $service = $row["job"];
                    $hand = $row["hand"];
                    $total = $row["total"];
                    $mydate = $row["date"];

                    echo '<tr>
                    <td>' . $id . '</td>
                    <td>' . $client . '</td>
                    <td>' . $service . '</td>
                    <td>' . $hand . '</td>
                    <td>' . number_format((float)$total, 2, ',', '.') . ' €</td>
                    <td>' . $mydate . '</td>
                    </tr>';
                }
                ?>
                </table>
                <br><br><br><br>
                <button class="btn btn-danger" onclick="window.close()">Cierra Esta Ventana</button>
                </div>
            </div>
        <div class="col-md-1" style="width:3%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>