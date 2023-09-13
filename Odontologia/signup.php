<?php
include "includes/conn.php";
$title = "Registro de Paciente";
include "includes/header.php";
include "includes/modal-update.html";
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
                    $already = false;
                    $patient = $_POST["patient"];
                    $surname = $_POST["surname"];
                    $surname2 = $_POST["surname2"];
                    $dni = $_POST["dni"];
                    $phone = $_POST["phone"];

                    $sql = "SELECT dni, phone FROM patient";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0)
                    {
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                        {
                            if ($row->dni == $dni || $row->phone == $phone)
                            {
                                $already = true;
                            }
                        }
                    }

                    if (!$already)
                    {
                        $sql = "INSERT INTO patient VALUES(:id, :name, :surname, :surname2, :dni, :phone);";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array(':id' => null, ':name' => $patient, ':surname' => $surname, ':surname2' => $surname2, ':dni' => $dni, ':phone' => $phone));
                        echo '<script>toast(0, "Datos Agregados", "Los Datos del Paciente ' . $patient . ' se han Agregado a la Base de Datos.");</script>';
                    }
                    else
                    {
                        echo '<script>toast(2, "Error de Datos", "Alguno de los Datos ya Está en el Sistema<br>Verifica que no se Repita el D.N.I. o el Teléfono de la Persona, tal vez ya Esté Registrada.");</script>';
                    }
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