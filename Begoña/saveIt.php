<?php
include "includes/conn.php";
include "includes/client.php";
include 'vendor/autoload.php';

if(isset($_REQUEST["id"]))
{
    $id = $_REQUEST["id"];

    $stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();

    $sql = ("SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE id=$id");
	
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);

    $sheet = new PhpOffice\PhpSpreadsheet\Spreadsheet(); // Hay que usarlo así en Wordpress, también funciona en cualquier script de PHP.
    $active_sheet = $sheet->getActiveSheet();

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

    $id = $row->id;
    $pat_id = $row->pat_id;
    $patient = getClient($conn, $pat_id);
    $service = $row->concept;
    $qtty = $row->qtty;
    $price = $row->partial;
    $total = $row->total;
    $mydate = $row->date;
    $time = $row->time;

    $active_sheet->setCellValue('A2', $id);
    $active_sheet->getStyle('A2')->getAlignment()->setHorizontal("left");
    $active_sheet->setCellValue('B2', $patient);
    $active_sheet->setCellValue('C2', $service);
    $active_sheet->setCellValue('D2', $mydate);
    $active_sheet->setCellValue('E2', $time);
    $active_sheet->setCellValue('F2', $qtty);
    $active_sheet->setCellValue('G2', $price * $qtty);
    $active_sheet->getStyle('G2')->getNumberFormat()->setFormatCode('#,##0.00 €');
    $active_sheet->setCellValue('H2', " 15% = " . $price * $qtty * .15 . " €");
    $active_sheet->getStyle('H2')->getAlignment()->setHorizontal("center");
    $active_sheet->setCellValue('I2', $total);
    $active_sheet->getStyle('I2')->getNumberFormat()->setFormatCode('#,##0.00 €');

	$active_sheet->setCellValue('H4', "Total:");
	$active_sheet->setCellValue('I4', $total);
	$active_sheet->getStyle('I4')->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('B6', "Begoña Moreno Megias - 42021197-J\nC/. Juan Padrón núm. 11, 1º izq.\n38003 SANTA CRUZ DE TENERIFE\nTe: 630738642\nE-mail: bmorenomegias@gmail.com");

    for ($i = 1; $i < 7; $i++)
    {
        if ($i != 1 && $i != 3 && $i != 5)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
        }
        else
        {
            $active_sheet->getRowDimension(1)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
        }
    }

    for ($j = 65; $j < 74; $j++)
    {
        $active_sheet->getColumnDimension(chr($j))->setWidth(15); // Si es la Letra C le da el tamaño horizontal 52.

        if ($j == 66)
        {
            $active_sheet->getColumnDimension(chr($j))->setWidth(40); // Si es la Letra C le da el tamaño horizontal 52.
        }
        if ($j == 67)
        {
            $active_sheet->getColumnDimension(chr($j))->setWidth(57); // Si es la Letra C le da el tamaño horizontal 52.
        }
        if ($j == 73)
        {
            $active_sheet->getColumnDimension(chr($j))->setWidth(24);
        }
    }
		
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($sheet, "Xlsx");

	$file_name = "Factura Nº $id - $mydate.Xlsx";

	$writer->save($file_name);

	header('Content-Type: application/x-www-form-urlencoded');

	header('Content-Transfer-Encoding: Binary');

	header("Content-disposition: attachment; filename=\"".$file_name."\"");

	readfile($file_name);

	unlink($file_name);

	exit;
}
?>