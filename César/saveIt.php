<?php
include "inc/conn.php";
include 'vendor/autoload.php';

if(isset($_REQUEST["id"]))
{
    $id = $_REQUEST["id"];

    $stmt = $conn->prepare("SET lc_time_names = 'es_ES'");
	$stmt->execute();

    $sql = "SELECT *, DATE_FORMAT(date,'%d %M %Y') as date FROM invoice WHERE id=$id";
	
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);

    $sheet = new PhpOffice\PhpSpreadsheet\Spreadsheet(); // Hay que usarlo así en Wordpress, también funciona en cualquier script de PHP.
    $active_sheet = $sheet->getActiveSheet();

	$active_sheet->setCellValue('A1', 'Nº de factura');
	$active_sheet->setCellValue('B1', 'Cliente');
	$active_sheet->setCellValue('C1', 'Servicio');
	$active_sheet->setCellValue('D1', 'Hora');
	$active_sheet->setCellValue('E1', 'Día');
	$active_sheet->setCellValue('F1', 'Base Imponible');
	$active_sheet->setCellValue('G1', 'I.G.I.C.');
    $active_sheet->getStyle('G1')->getAlignment()->setHorizontal("center");
	$active_sheet->setCellValue('H1', 'Total + I.G.I.C.');

    $id = $row->id;
    $client = $row->client;
    $service = $row->job;
    $price = $row->price;
    $totaligic = $row->totaligic;
    $mydate = $row->date;
    $time = $row->time;

    $active_sheet->setCellValue('A2', $id);
    $active_sheet->getStyle('A2')->getAlignment()->setHorizontal("left");
    $active_sheet->setCellValue('B2', $client);
    $active_sheet->setCellValue('C2', $service);
    $active_sheet->setCellValue('D2', $time);
    $active_sheet->setCellValue('E2', $mydate);
    $active_sheet->setCellValue('F2', $price);
    $active_sheet->getStyle('F2')->getNumberFormat()->setFormatCode('#,##0.00 €');
    $active_sheet->setCellValue('G2', "7%");
    $active_sheet->getStyle('G2')->getAlignment()->setHorizontal("center");
    $active_sheet->setCellValue('H2', $totaligic);
    $active_sheet->getStyle('H2')->getNumberFormat()->setFormatCode('#,##0.00 €');

	$active_sheet->setCellValue('G4', "Total:");
	$active_sheet->setCellValue('H4', $totaligic);
	$active_sheet->getStyle('H4')->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A6', "César Osvaldo Matelat Borneo - 42268151Q Calle Fermín Morín Nº 2, 38007, Santa Cruz de Tenerife");

    for ($i = 1; $i < 3; $i++)
    {
        $active_sheet->getRowDimension($i)->setRowHeight(60); // Cambia el tamaño Vertical de las filas usadas en la planilla.

        if ($i == 1)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getColumnDimension(chr(64 + $i))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 1))->setWidth(40); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 2))->setWidth(50); // Si es la Letra C le da el tamaño horizontal 52.
            for ($j = 68; $j < 72; $j++)
            {
                $active_sheet->getColumnDimension(chr($j))->setWidth(15); // Si es la Letra C le da el tamaño horizontal 52.
            }
            $active_sheet->getColumnDimension(chr(64 + $i + 7))->setWidth(20);
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