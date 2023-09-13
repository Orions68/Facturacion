<?php
include "includes/conn.php";
$title = "Pacientes con Cita en Este Momento";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div id="pc"></div>
    <div id="mobile"></div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
                <h1>Estos son los Pacientes que Tienen Cita Hoy</h1>
                <br>
                <?php
                if (isset($_REQUEST["id"]))
                {
                    $id = $_REQUEST["id"];
                    if ($id == "index")
                    {
                        echo '<form action="index.php" method="post" target="_self">';
                    }
                    else
                    {
                        echo '<form action="dates.php" method="post" target="_self">';
                    }
                }
                ?>
                <label><select name="patient" required>
                    <option value="">Selecciona el Paciente a Facturar</option>
                    <?php
                    $sql = "SELECT patient.id, patient.name FROM patient INNER JOIN date WHERE date.date=DATE(NOW()) AND date.patient_id=patient.id;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0)
                    {
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                        {
                            echo '<option value="' . $row->id . "," . $row->name . '">' . $row->name . '</option>';
                        }
                    }
                    ?>
                    </select> Nombre del Paciente</label>
                    <br><br>
                    <input class="btn btn-primary" type="submit" value="Este Paciente">
            </form>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>