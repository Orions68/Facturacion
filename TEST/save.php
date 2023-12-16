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
                        $total = 0;
                        $material = [];
                        for ($i = 0; $i < count($_POST) - 1; $i++)
                        {
                            $material[$i] = $_POST["input" . $i];
                            echo $material[$i] . "<br>";
                            $total += $material[$i];
                        }
                        echo "Mano de Obra = " . $_POST["hand"];
                        echo "Total: " . $_POST["hand"] + $total;
                    }
                    if ($_POST["hand"] == "")
                    {
                        echo '<script>alert ("No Mostro no mandaste nada.");</script>';
                    }
                    ?>
                    <form action="otro.php" method="post">
                        <label><input type="text" name="valor"> Primer Valor</label>
                        <br><br>
                        <input type="submit" value="Envia Este">
                        <br><br>
                        <label><input type="text" name="valor"> Segundo Valor</label>
                        <br><br>
                        <input type="submit" value="Envia Este">
                        <br><br>
                        <label><input type="text" name="valor"> Tercer Valor</label>
                        <br><br>
                        <input type="submit" value="Envia Este">
                        <br><br>
                    </form>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>