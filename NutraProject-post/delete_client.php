<?php // Script para eliminar un perfil de Cliente.
include "includes/conn.php";
$title = "Eliminando un Cliente";
include "includes/header.php";
include "includes/modal-dismiss.html";
if (isset($_POST["id"])) // Si se recibe la id del alumno.
{
    $id = $_POST["id"];
    $sql = "DELETE FROM client WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) // Lo borró de la base de datos.
    {
        session_destroy(); // Destruyo la sesión
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
        echo "<script>toast(2, 'Se Ha Eliminado Tu Perfil', 'Gracias por Haber Sido Parte de Nutra Project.');</script>";
    }
}
else // Si no llegaron datos por POST.
{
    echo "<script>toast(2, 'Llegaste Aquí por Error', 'No se ha Eliminado Ningún Perfil.');</script>";
}
?>
<br><br>
					<input type="button" value="Cierra Esta Ventana" onclick="window.open('index.php', '_self')">
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>