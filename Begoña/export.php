<?php
include 'includes/conn.php';
include "includes/client.php";
include 'vendor/autoload.php';

$sheet = new PhpOffice\PhpSpreadsheet\Spreadsheet(); // Hay que usarlo así en Wordpress, también funciona en cualquier script de PHP.

	$date = $_POST['date']; // El Trimestre recibido desde admin.php.
	$year = $_POST['year']; // El Año recibido desde admin.php.
	$service = "";
	
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
	$file = $sheet; // Usado en Wordpress, también funciona en cualquier script de PHP.

	$active_sheet = $file->getActiveSheet();

	$active_sheet->setCellValue('A1', 'Nº de factura');
	$active_sheet->setCellValue('B1', 'Cliente');
	$active_sheet->setCellValue('C1', 'Concepto');
	$active_sheet->setCellValue('D1', 'Día');
	$active_sheet->setCellValue('E1', 'Hora');
    $active_sheet->setCellValue('F1', 'Cantidad');
	$active_sheet->setCellValue('G1', 'Base Imponible');
	$active_sheet->setCellValue('H1', 'I.R.P.F.');
    $active_sheet->getStyle('H1')->getAlignment()->setHorizontal("center");
	$active_sheet->setCellValue('I1', 'Total Descontando I.R.P.F.');

	$count = 2;
	$total = 0;

	foreach($result as $row)
	{
        $id = $row["id"];
        $pat_id = $row["pat_id"];
        $patient = getClient($conn, $pat_id);
        $service = $row["concept"];
        $qtty = $row["qtty"];
        $price = $row["partial"];
        $total = $row["total"];
        $irpf = $price * $qtty - $total;
        $mydate = $row["date"];
        $time = $row["time"];

		$active_sheet->setCellValue('A' . $count, $id);
        $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal("left");
		$active_sheet->setCellValue('B' . $count, $patient);
		$active_sheet->setCellValue('C' . $count, $service);
		$active_sheet->setCellValue('D' . $count, $mydate);
		$active_sheet->setCellValue('E' . $count, $time);
        $active_sheet->getStyle('E' . $count)->getAlignment()->setHorizontal("right");
        $active_sheet->setCellValue('F' . $count, $qtty);
        $active_sheet->getStyle('F' . $count)->getAlignment()->setHorizontal("center");
		$active_sheet->setCellValue('G' . $count, $price * $qtty);
		$active_sheet->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
        $active_sheet->getStyle('G' . $count)->getAlignment()->setHorizontal("center");
		$active_sheet->setCellValue('H' . $count, "15 % = " . $irpf . " €");
        $active_sheet->getStyle('H' . $count)->getAlignment()->setHorizontal("center");
		$active_sheet->setCellValue('I' . $count, $total);
		$active_sheet->getStyle('I' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

		$count++;
	}

	$active_sheet->setCellValue('H' . ($count + 2), "Total:");
	$active_sheet->setCellValue('I' . ($count + 2), "=SUM(I2:I" . ($count - 1) . ")");
	$active_sheet->getStyle('I' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('B' . ($count + 4), "Begoña Moreno Megias - 42021197-J\nC/. Juan Padrón núm. 11, 1º izq.\n38003 SANTA CRUZ DE TENERIFE\nTe: 630738642\nE-mail: bmorenomegias@gmail.com");

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
            $active_sheet->getColumnDimension(chr(64 + $i + 6))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 7))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 8))->setWidth(24);
        }

        if ($i == $count - 1)
        {
            $active_sheet->getRowDimension($i + 3)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getRowDimension($i + 5)->setRowHeight(82); // Cambia el tamaño Vertical de las filas usadas en la planilla.
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
                        <h4>Facturas: <?php echo " " . $date; ?>º Trimestre del año: <?php echo " " . $year; ?> Begoña Moreno Megias - 42021197-J<br>C/. Juan Padrón núm. 11, 1º izq.<br>38003 SANTA CRUZ DE TENERIFE<br>Te: 630738642<br>E-mail: bmorenomegias@gmail.com</h4>
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
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Cantidad</th>
                    <th>Base Imponible</th>
                    <th>I.R.P.F.</th>
                    <th>Total Descontando I.R.P.F.</th>
                    </tr>
                <?php

                foreach($result as $row)
                {
                    $id = $row["id"];
                    $pat_id = $row["pat_id"];
                    $patient = getClient($conn, $pat_id);
                    $service = $row["concept"];
                    $qtty = $row["qtty"];
                    $price = $row["partial"];
                    $total = $row["total"];
                    $irpf = $price * $qtty - $total;
                    $mydate = $row["date"];
                    $time = $row["time"];

                    echo '<tr>
                    <td>' . $id . '</td>
                    <td>' . $patient . '</td>
                    <td>' . $service . '</td>
                    <td>' . $mydate . '</td>
                    <td>' . $time . '</td>
                    <td>' . $qtty . '</td>
                    <td>' . number_format((float)$price * $qtty, 2, ',', '.') . ' €</td>
                    <td>15 % = ' . $irpf . ' €</td>
                    <td>' . number_format((float)$total, 2, ',', '.') . ' €</td>
                    </tr>';
                }
                ?>
                </table>
                <br><br><br><br>
                <button class="btn btn-danger btn-lg" onclick="window.close()">Cierra Esta Ventana</button>
                </div>
            </div>
        <div class="col-md-1" style="width:3%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>