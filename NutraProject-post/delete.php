<?php
include "includes/conn.php";
$title = "Borrando Factura";
include "includes/header.php";
include "includes/modal-dismiss.html";
if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    $sql = "DELETE FROM invoice WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) // Lo borró de la base de datos.
    {
        ?>
        <img alt="logo" src="img/logo.webp" height="300" width="100%"/>
        <br>
        <section class="container-fluid pt-3">
            <div class="row">
            <div id="pc"></div>
            <div id="mobile"></div>
                <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div id="view1">
                            <br><br><br><br>
        <?php
        $sql = "SET @count = 0; UPDATE invoice SET id = @count:= @count + 1; ALTER TABLE invoice AUTO_INCREMENT = 1;"; // Arreglo los índices de las facturas.
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo "<script>toast(0, 'Se Ha Eliminado la Factura', 'Ahora se Arreglará el Índice para que las Facturas Sean Correlativas.');</script>";
    }
}
?>
                    <br><br>
					<input type="button" value="Cierra Esta Ventana" onclick="window.close()">
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>