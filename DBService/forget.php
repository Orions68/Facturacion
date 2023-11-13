<?php
$title = "Recuperación. de Contraseña";
include "includes/header.php";
include "includes/nav.html";

if (isset($_POST["email"])) // Verifco si llega una solicitud con un email a este script
{
    $email =  urlencode($_POST["email"]); // Asigno a la variable $email el contenido del $_POST["email"] y lo codifico con urlencode.

    $url = "http://localhost/DBService/service.php?forget=1&email=$email"; // Asigno a la variable $url la url del servicio pasandole los datos por GET.

    $data = json_decode(file_get_contents("$url"), true); // Asigno a la variable $data el resultado decodificado de la llamada al servicio.
}
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view4">
                    <br><br><br><br><br>
                    <h2>Quinto Servicio Recupera Contraseña - Genera la Contraseña 1111 e Informa al Usuario para Cambiarla Inmediatamente.</h2>
                    <form action="" method="post">
                        <label><input type="email" name="email" required> E-mail del Usuario.</label>
                        <br><br>
                        <input type="submit" name="forget" value="Recupera Mi Contraseña">
                    </form>
                    <br><br>
                    <?php
                    if (isset($_POST["forget"])) // Si llega la solicitud forget.
                    {
                        echo "<h3>" . $data["message"] . ", " . $data["data"] . "</h3>"; // Muestro el resultado.
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