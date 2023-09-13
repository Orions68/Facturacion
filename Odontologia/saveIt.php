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
	$active_sheet->setCellValue('B1', 'Paciente');
    $active_sheet->setCellValue('C1', 'Profesional');
	$active_sheet->setCellValue('D1', 'Servicio');
	$active_sheet->setCellValue('E1', 'Hora');
	$active_sheet->setCellValue('F1', 'Día');
	$active_sheet->setCellValue('G1', 'Base Imponible');
	$active_sheet->setCellValue('H1', 'I.G.I.C.');
    $active_sheet->getStyle('H1')->getAlignment()->setHorizontal("center");
	$active_sheet->setCellValue('I1', 'Total + I.G.I.C.');

	$count = 2;

    $id = $row->id;
    include "getName.php";
    $patient = getName($conn, $row->patient_id, "P");
    $doc = getName($conn, $row->doc_id, "D");
    $desc = $row->description;
    $price = $row->price;
    $total = $row->total;
    $mydate = $row->date;
    $time = $row->time;

    $active_sheet->setCellValue('A' . $count, $id);
    $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal("left");
    $active_sheet->setCellValue('B' . $count, $patient);
    $active_sheet->setCellValue('C' . $count, $doc);
    $active_sheet->setCellValue('D' . $count, $desc);
    $active_sheet->setCellValue('E' . $count, $time);
    $active_sheet->setCellValue('F' . $count, $mydate);
    $active_sheet->setCellValue('G' . $count, $total);
    $active_sheet->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
    $active_sheet->setCellValue('H' . $count, "Excento");
    $active_sheet->getStyle('H' . $count)->getAlignment()->setHorizontal("center");
    $active_sheet->setCellValue('I' . $count, $total);
    $active_sheet->getStyle('I' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

	$active_sheet->setCellValue('H' . ($count + 2), "Total:");
	$active_sheet->setCellValue('I' . ($count + 2), $total);
	$active_sheet->getStyle('I' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A' . ($count + 4), "Clínica Odontológica - C.I.F. 42000000Q Calle X Nº 2, 38001, Santa Cruz de Tenerife");

    for ($i = 1; $i <= $count; $i++)
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
            $active_sheet->getColumnDimension(chr(64 + $i + 8))->setWidth(15);
        }

        if ($i == $count - 1)
        {
            $active_sheet->getRowDimension($i + 3)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getRowDimension($i + 5)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.
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