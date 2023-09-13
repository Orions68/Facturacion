<?php
$title = "Facturando";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
                    <h1>Resultados:</h1>
                    <br><br>
                    <?php
                    if (isset($_POST["hand"]))
                    {
                        $material = [];
                        for ($i = 0; $i < count($_POST) - 1; $i++)
                        {
                            $material[$i] = $_POST["input" . $i];
                            echo $material[$i] . "<br>";
                        }
                    }
                    else
                    {
                        echo '<script>alert ("No Mostro no mandaste nada");</script>';
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