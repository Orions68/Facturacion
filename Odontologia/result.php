<?php
include "includes/conn.php";
$title = "Resultado de Profesionales";
include "includes/header.php";

if (isset($_POST["doc"]))
{
    $id = $_POST["doc"];
    include "getName.php";
    $doc = getName($conn, $id, "D");
    $month = $_POST["month"];
    if ($month < 10)
    {
        $month = "0" . $month;
    }

    $file = $sheet; // Usado en Wordpress, también funciona en cualquier script de PHP.

	$active_sheet = $file->getActiveSheet();

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

    $sql = "CALL GetResults($id, '$month')"; // Uso un Procedure que me devuelve los trabajos del profesional en el mes requerido.
    $stmt = $conn->prepare($sql); // Hago la conexión a la base de datos.
    $stmt->execute(); // La ejecuto.
    if ($stmt->rowCount() > 0) // Si hay resultados.
    {
        $count = 2;
        include "getName.php";
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo en la variable $row todos los campos del resultado de la consulta.
        {
            $id = $row->id;
            $patient = getName($conn, $row->patient_id, "P");
            $doc = getName($conn, $row->doc_id, "D");
            $desc = $row->description;
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

            $count++;
        }
    }
}
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>