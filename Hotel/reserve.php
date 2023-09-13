<?php
include "includes/conn.php";
$title = "Reservando Habitación.";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></dvi>
            <div class="col-md-10">
                <?php
                    if (isset($_POST["room"]))
                    {
                        $room = $_POST["room"];
                        $client = $_POST["client"];
                        $dni = $_POST["dni"];
                        echo "El Cliente $client con D.N.I. $dni, ha reservado la habitación $room";
                    }
                ?>
            </div>
        <div class="col-md-1"></dvi>
    </div>
<section>
<?php
include "includes/footer.html";
?>