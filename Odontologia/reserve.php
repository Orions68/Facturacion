<?php
include "includes/conn.php";
$title = "Cita Reservada";
include "includes/header.php";
include "includes/modal-index.html";
?>
<section class="container-fluid pt-3">
    <div id="pc"></div>
    <div id="mobile"></div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
                <?php
                if (isset($_POST["patient"]))
                {
                    $patient = $_POST["patient"];
                    $id = $_POST["id"];
                    $doc = $_POST["doctor_id"];
                    $doctor = $_POST["doctor"];
                    $date = $_POST["date"];
                    $latin = explode("-", $date);
                    $time = $_POST["time"];
                    $sql = "INSERT INTO date VALUES(:id, :patient_id, :doc_id, :date, :time);";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array(':id' => null, ':patient_id' => $id, ':doc_id' => $doc, ':date' => $date, ':time' => $time));
                    echo "<script>toast(0, 'Cita del Paciente: " . $patient . "', 'Reservada Correctamente para el Día: " . $latin[2] . "/" . $latin[1] . "/" . $latin[0] . " a las: " . $time . "<br> con: " . $doctor . "')</script>";
                }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>