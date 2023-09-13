<?php
include "includes/conn.php";
$title = "Busca los Pacientes por el DNI";
include "includes/header.php";
include "includes/modal.html";
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
                if (isset($_POST["dni"]))
                {
                    $dni = $_POST["dni"];
                    $sql = "SELECT id, name FROM patient WHERE dni='$dni';";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0)
                    {
                        $row = $stmt->fetch(PDO::FETCH_OBJ);
                        ?>
                        <h3>Se ha encontrado: <?php echo $row->name;?></h3>
                        <form action="dates.php" method="post">
                            <input type="hidden" name="patient" value="<?php echo $row->id . "," . $row->name; ?>">
                            <input class="btn btn-primary btn-lg" type="submit" value="Paciente para la Cita">
                        <?php
                    }
                    else
                    {
                        echo "<script>toast(1, 'Paciente no Registrado:', 'El D.N.I. Ingresado no Corresponde a Ningún Paciente Registrado<br>Dalo de Alta Desde el Menu en la Página Principal.');</script>";
                    }
                }
                else
                {
                    echo "<script>toast(2, 'Error Grave:', 'Haz Llegado Aquí por Error.');</script>";
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