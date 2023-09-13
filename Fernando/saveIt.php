<?php
include "includes/conn.php";
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
	$active_sheet->setCellValue('C1', 'Servicio');
    $active_sheet->setCellValue('D1', 'Mano de Obra');
	$active_sheet->setCellValue('E1', 'Día');
	$active_sheet->setCellValue('F1', 'Total');

	$count = 2;

    $id = $row->id;
    $client = $row->client;
    $service = $row->job;
    $hand = $row->hand;
    $total = $row->total;
    $mydate = $row->date;

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
    $active_sheet->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

	$active_sheet->setCellValue('F' . ($count + 2), "Total:");
	$active_sheet->setCellValue('G' . ($count + 2), $total);
	$active_sheet->getStyle('G' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A' . ($count + 4), "Fernando Ariel Filippelli - Y0575228N Camino La Unión 31 38270 Valle de Guerra");

    for ($i = 1; $i < 3; $i++)
    {
        $active_sheet->getRowDimension($i)->setRowHeight(60); // Cambia el tamaño Vertical de las filas usadas en la planilla.

        if ($i == 1)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getColumnDimension(chr(64 + $i))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 1))->setWidth(40); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 2))->setWidth(50); // Si es la Letra C le da el tamaño horizontal 52.
            for ($j = 68; $j < 75; $j++)
            {
                $active_sheet->getColumnDimension(chr($j))->setWidth(15); // Si es la Letra C le da el tamaño horizontal 52.
            }
        }
    }
    $active_sheet->getRowDimension($i + 1)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
    $active_sheet->getRowDimension($i + 3)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
    $active_sheet->getRowDimension($i + 5)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
		
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