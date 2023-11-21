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
	$active_sheet->setCellValue('D1', 'Cantidad');
	$active_sheet->setCellValue('E1', 'Día');
	$active_sheet->setCellValue('F1', 'Base Imponible');
    $active_sheet->getStyle('G1')->getAlignment()->setHorizontal("center");
    $active_sheet->setCellValue('H1', 'A Pagar de I.V.A.');
	$active_sheet->setCellValue('I1', 'Total + I.V.A.');
    $active_sheet->getStyle('I1')->getAlignment()->setHorizontal("right");

	$count = 2;

    $id = $row->id;
    $client = $row->client_id;
    if ($client == null)
    {
        $client = "Consumidor Final";
    }
    else
    {
        $sql = "SELECT name FROM client WHERE id=$client;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $client = $row->name;
    }

    $sql = "SELECT * FROM sold WHERE invoice_id=$id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        $index = 0;
        while ($row_product = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $productArray[$index] = $row_product->product_id;
            $qttyArray[$index] = $row_product->qtty;
            $index++;
        }
    }

    $product = "";
    for ($i = 0; $i < count($productArray) - 1; $i++)
    {
        $product .= getProduct($conn, $productArray[$i]);
    }

    $qtty = "";
    for ($i = 0; $i < count($qttyArray) - 1; $i++)
    {
        $qtty .= $qttyArray[$i] . "\n";
    }
    $total = $row->total;
    $mydate = $row->date;

    $active_sheet->setCellValue('A' . $count, $id);
    $active_sheet->getStyle('A' . $count)->getAlignment()->setHorizontal("left");
    $active_sheet->setCellValue('B' . $count, $client);
    $active_sheet->setCellValue('C' . $count, $product);
    $active_sheet->setCellValue('D' . $count, $qtty);
    $active_sheet->setCellValue('E' . $count, $mydate);
    $active_sheet->setCellValue('F' . $count, $total - $iva);
    $active_sheet->getStyle('F' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
    $active_sheet->setCellValue('G' . $count, "21 %");
    $active_sheet->getStyle('G' . $count)->getAlignment()->setHorizontal("center");
    $active_sheet->getStyle('H' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');
    $active_sheet->setCellValue('I' . $count, $total);
    $active_sheet->getStyle('I' . $count)->getNumberFormat()->setFormatCode('#,##0.00 €');

	$active_sheet->setCellValue('H' . ($count + 2), "Total:");
	$active_sheet->setCellValue('I' . ($count + 2), $total);
	$active_sheet->getStyle('I' . ($count + 2))->getNumberFormat()->setFormatCode('#,##0.00 €');
	$active_sheet->setCellValue('A' . ($count + 4), "César Osvaldo Matelat Borneo - 42268151Q Calle Fermín Morín Nº 2, 38007, Santa Cruz de Tenerife");

    for ($i = 1; $i <= $count; $i++)
    {
        $active_sheet->getRowDimension($i)->setRowHeight(40); // Cambia el tamaño Vertical de las filas usadas en la planilla.

        if ($i == 1)
        {
            $active_sheet->getRowDimension($i)->setRowHeight(20); // Cambia el tamaño Vertical de las filas usadas en la planilla.
            $active_sheet->getColumnDimension(chr(64 + $i))->setWidth(15);
            $active_sheet->getColumnDimension(chr(64 + $i + 1))->setWidth(27); // Si es la Letra B le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 2))->setWidth(57); // Si es la Letra C le da el tamaño horizontal 52.
            $active_sheet->getColumnDimension(chr(64 + $i + 3))->setWidth(15); // Si es la Letra D le da el tamaño horizontal 52.
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

function getProduct($conn, $id)
{
    $sql = "SELECT product FROM product WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row_product = $stmt->fetch(PDO::FETCH_OBJ);
    $product = $row_product->product . "\n";
    return $product;
}
?>