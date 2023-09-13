<?php
include "includes/conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="4"> <!-- Recarga la página cada 4 segundos. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting</title>
</head>
<body>
    <br><br><br><br><br><br><br><br><br><br>
    <?php
    if (empty($_SESSION["client"])) // Si está vacia la session client.
    {
        echo'<h1 id="timer">Serás redirigido en 4 segundos.</h1>'; // Muestro que se actualizará la página en 4 segundos.
    }
    else // Si ya se abrió la sesión client.
    {
        echo'<h1 id="timer">Serás redirigido en 0 segundos.</h1>'; // Muetro 0 segundos, ya paso el tiempo se recargó la página y pasará los datos al script profile.php.
    }
    ?>
    <script>
        let timer = document.getElementById("timer"); // Id del H1 que muestra el contador.
        var number = 4; // La cantidad de segundos del contador.
        function wait() // Función que se llama cada 1 segundo, hasta que number es 0.
        {
            setTimeout(function() { // Contador (timer).
                if (number > 0) // Si number es mayor que 0.
                {
                    number--; // Decrementa number.
                    timer.innerHTML = "Serás redirigido en " + number + " segundos."; // Pone la leyenda en el H1.
                    wait(); // Llama a la función
                }
            },1000) // Espera 1 segundo.
        }
        wait(); // Llamo a la función por primera vez.
    </script>
    <?php
    if (isset($_POST["email"])) // Si llegó el email por POST.
    {
        $email = $_POST["email"]; // Lo asigno a la variable $email.
        $array = explode("@", $email); // Lo exploto en $array por la @.
        $_SESSION["save"] = $array[0]; // Guardo en la variable $_SESSION["save"], el contenido de $array en la posición 0, el nombre del email.
        $pass = $_POST["pass"]; // Asigno a $pass la contraseña que llega por POST.
        $name = $array[0] . "login.txt"; // Asigno a la varable $name el nombre del email y la palabra login con la extensión txt.
        if (!file_exists($name)) // Si el archivo con nombre $name no existe.
        {
            $file = fopen($name, "w") or die("Unable to open file!"); // Lo abro para escritura.
            fwrite($file, $email); // Escribo el email.
            fwrite($file, ";"); // Escribo un ;.
            fwrite($file, $pass); // Escribo la contraseña.
        }
        fclose($file); // Cierro el archivo.
        $response["error"] = false; // Preparo la respuesta al script de llamada.
        echo json_encode($response); // La codifico en json y la envío.
        exit(); // Salgo del script.
    }
    if (empty($_SESSION["client"])) // Si la sesión client está vacia.
    {
        $_SESSION["client"] = -1; // le asigno un -1.
    }
    else // La segunda vez que entra, cuando se recarga la página, la sesión client ya no está vacia.
    {
        $email = $_SESSION["save"]; // Pongo en la variable $email el contenido de $_SESSION["save"].
        session_destroy(); // Destruyo todas las sesiones.
        $name = $email . "login.txt"; // Asigno al a variable $name, la variable $email más login y la extensión txt.
        $file = fopen($name, "r") or die("Unable to open file!"); // Abro el archivo $name para lectura.
        $data = fread($file, filesize($name)); // Leo el contenido en la variable $data.
        $array = explode(";", $data); // Exploto el contenido de $data en $array por el ;.
        fclose($file); // Cierro el archivo.
        echo '<form name="data" method="post" action="profile.php" target="_self">'; // Creo el formulario con los datos email y pass.
        echo '<input type="hidden" name="email" value="' . $array[0] . '">';
        echo '<input type="hidden" name="pass" value="' . $array[1] . '">';
        echo '</form>';
        echo '<script type="text/javascript">document.forms["data"].submit();</script>'; // Envio el formulario automaticamente.
    }
    ?>
</body>
</html>