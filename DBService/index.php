<?php
session_start(); // Inicio la sesión.
ob_start();
if (empty($_SESSION["index"])) // Verifico si la sesion index está vacia.
{
    $_SESSION["index"] = 1; // Si es así le asigno el valor 1.
}
setlocale(LC_ALL, 'spanish'); // Pongo el locale a españa para leer las fechas en español

switch (true) // Hago un switch a la solicitud que sea true.
{
    case isset($_POST["create"]): // Si llego $_POST["create"].
        $name = urlencode($_POST["username"]); // Codifico el nombre de usuario ya que puede tener espacios, uso urlencode ya que htmlspecialchars no soluciona el problema
        // de pasar una cadena con espacios por la url.
        $surname = urlencode($_POST["surname"]);
        $phone = urlencode($_POST["phone"]);
        $email = urlencode($_POST["email"]);
        $pass = urlencode($_POST["pass"]);
        $bday = urlencode($_POST["bday"]);
        $gender = urlencode($_POST["gender"]);
        $img = $_FILES["profile"]["name"];
        $tmp = $_FILES["profile"]["tmp_name"];

        if ($img != "") // Si el Usuario sube una imagen.
        {
            if (!is_dir("tmp")) // Si no existe el directorio tmp.
            {
                mkdir("tmp", 0777, true); // Lo creo.
            }
            $img_name = basename($img); // Obtengo el nomre de la imagen.
            $path = "tmp/" . $img_name; // Asigno a la variable $path la ruta tmp/Nombre de la foto.
            move_uploaded_file($tmp, $path); // Muevo el archivo de la carpeta temporal del sistema a mi carpeta temporal en la ruta $path.
            $img = urlencode($img_name); // Codifico el nombre de la imagen ya que puede tener espacios.
        }

        $url = "http://localhost/DBService/service.php?create=1&name=$name&surname=$surname&phone=$phone&email=$email&pass=$pass&bday=$bday&gender=$gender&img=$img";
        // Asigno a la variable $url la ruta del servicio pasandole todos los datos por get.
        $data = json_decode(file_get_contents("$url"), true); // Asigno la llamada a la variable $data, decodificando la respuesta que es un JSON.
        break; // Salgo del Switch.
    case isset($_POST["read"]): // Si llego ua solicitud $_POST["read"].
        $id = urlencode($_POST["id"]); // Si llego la ID del usuario a mostrar se la asigno a la variable $id haciendo urlencode.

        if ($id != "") // Si la variable $id contiene algún dato.
        {
            $url="http://localhost/DBService/service.php?read=1&id=$id"; // Asigno a la variable $url la ruta al servicio con los datos por get
        }
        else // Si la variable $id está vacía.
        {
            $_SESSION["index"] = 1; // Asigno a la variable de sesión index el valor 1.
            $url="http://localhost/DBService/service.php?read=1&id="; // Asigno a la variable $url la ruta al servicio con los datos por get con la id vacía, muestra todos los resultados.
        }

        $data = json_decode(file_get_contents("$url"), true); // Asigno la llamada a la variable $data, decodificando la respuesta que es un JSON.
        break; // Salgo del Switch.
    case isset($_POST["update"]): // Si llego ua solicitud $_POST["update"].
        $id = $_POST["id"];
        $name = urlencode($_POST["username"]);
        $surname = urlencode($_POST["surname"]);
        $phone = urlencode($_POST["phone"]);
        $email = urlencode($_POST["email"]);
        $pass = urlencode($_POST["pass"]);
        $bday = $_POST["bday"];
        $gender = $_POST["gender"];
        $img = $_FILES["profile"]["name"];
        $tmp = $_FILES["profile"]["tmp_name"];
        $path = urlencode($_POST["path"]);

        if ($img != "") // Si el Usuario sube una imagen.
        {
            $ruta = "users/" . $id; // Asigno a la variable $ruta la ruta que va a contener la imagen del usuario, la carpeta users y su ID.
            if (!is_dir($ruta)) // Si no existe el directorio con el nombre de la $ruta.
            {
                mkdir($ruta, 0777, true); // Lo creo.
            }
            $path = $ruta . "/" . basename($img); // Asigno a la variable $path la ruta con la $ruta/Nombre de la foto.
            move_uploaded_file($tmp, $path); // Muevo el archivo a la ruta $path.
            $path = urlencode($path);
        }

        $url = "http://localhost/DBService/service.php?update=1&id=$id&name=$name&surname=$surname&phone=$phone&email=$email&pass=$pass&bday=$bday&gender=$gender&path=$path";

        $data = json_decode(file_get_contents("$url"), true);
        break;
    case isset($_POST["delete"]):
        $id = urlencode($_POST["id"]);

        $url = "http://localhost/DBService/service.php?delete=1&id=$id";

        $data = json_decode(file_get_contents("$url"), true);
        break;
    case isset($_POST["login"]):
        $email = urlencode($_POST["email"]);
        $pass = urlencode($_POST["pass"]);

        $url = "http://localhost/DBService/service.php?login=1&email=$email&pass=$pass";

        $data = json_decode(file_get_contents("$url"), true);
        break;
}
$title = "Servicio de CRUD a la Base de Datos";
include "includes/header.php";
include "includes/modal-img.html";
include "includes/modal.html";
include "includes/nav.html";
?>
<script src="js/script.js"></script> <!-- js de Bootstrap y mi js. -->
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br>
                    <h1 class="center">CRUD a la Base de Datos a Través de un Servicio</h1>
                    <br>
                    <h2>Primer Servicio CREATE - Inserta un Usuario en la Base de Datos</h2>
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return verify(1)">
                        <label><input type="text" name="username" required> Nombre del Usuario.</label>
                        <br><br>
                        <label><input type="text" name="surname" required> Apellidos del Usuario.</label>
                        <br><br>
                        <label><input type="number" name="phone" required> Teléfono del Usuario.</label>
                        <br><br>
                        <label><input type="email" name="email" required> E-mail del Usuario.</label>
                        <br><br>
                        <label><input type="password" id="pass" name="pass" required> Contraseña</label>
                        <br><br>
                        <label><input type="password" id="pass2" required> Repite Contraseña</label>
                        <br><br>
                        <label><input type="date" name="bday" required> Fecha de Nacimiento</label>
                        <br><br>
                        <label><input type="radio" name="gender" value="0" checked> Mujer</label>
                        <br><br>
                        <label><input type="radio" name="gender" value="1"> Varón</label>
                        <br><br>
                        <label><input type="file" name="profile" class="btn btn-primary btn-lg"> Foto de Perfil<small>(opcional)</small></label>
                        <br><br>
                        <input type="submit" name="create" value="Inserta Usuario" class="btn btn-info btn-lg">
                    </form>
                    <br><br>
                    <?php
                    if (isset($_POST["create"])) // Si se solicito crear un usuario
                    {
                        session_unset(); // Rompo la sesión
                        echo "<h3 class='blue'>" . $data["message"] . $data["data"] . "</h3>"; // Muestro los datos que devuelve la llamada al servicio.
                    }
                    ?>
                </div>
                <div id="view2">
                    <br><br><br>
                    <h2>Segundo Servicio READ - Consulta de Usuarios por ID, en Blanco Muestra Todos los Usuarios.</h2>
                    <form action="" method="post">
                        <label><input type="number" name="id"> ID del Registro a Consultar.</label>
                        <br><br>
                        <input type="submit" name="read" value="Consulta" class="btn btn-success btn-lg">
                        <br><br>
                    </form>
                    <?php
                    if (isset($_POST["read"])) // Si se solicitó la lectura de los datos de una ID o de todos los resultados.
                    {
                        $id = $_POST["id"]; // Asigno a la variable $id lo que llega por $_POST["id"].
                        if ($id != "") // Si contiene algún dato.
                        {
                            session_unset(); // Rompo la sesión
                            if ($data["status"] == 200) // Si el estado devuelve el código 200
                            {
                                echo "<h3 class='blue'>" . $data["message"] . "</h3>"; // Muestro el resultado en una tabla.
                                $html = "<table><tr>";
                                $html .= "<th>Nombre</th><th>Teléfono</th><th>E-mail</th><th>Fecha de Nacimiento</th><th>Genero</th><th>Imagen de Perfil</th><tr>";
                                $html .= "<td>" . $data["data"][0]["name"] . "</td>";
                                $html .= "<td>" . $data["data"][0]["surname"] . "</td>";
                                $html .= "<td>" . $data["data"][0]["phone"] . "</td>";
                                $html .= "<td>" . $data["data"][0]["email"] . "</td>";
                                $date = explode("-", $data["data"][0]["bday"]);
                                $dateObj   = DateTime::createFromFormat('!m', $date[1]);
                                $monthName = strftime('%B', $dateObj->getTimestamp());
                                $html .= "<td>" . $date[2] . "/" . $monthName . "/" . $date[0] . "</td>";
                                if ($data["data"][0]["gender"] == 0)
                                {
                                    $html .= "<td>Femenino</td>";
                                }
                                else
                                {
                                    $html .= "<td>Masculino</td>";
                                }
                                $html .= "<td><a href='javascript:showImg(\"" . $data["data"][0]["path"] . "\")'><img src='" . $data["data"][0]["path"] . "' width='160' height='80'></a></td>";

                                $html .= "</tr></table>";
                                echo $html;
                            }
                            else // Si no.
                            {
                                echo "<h3 class='red'>" . $data["message"] . "</h3>"; // Muestro el resultado que no se encuentra ese dato en la base de datos.
                            }
                        }
                        else // Si $id está vacía.
                        {
                            if ($data["status"] == 200) // Si el código de devolución es 200
                            {
                                $length = count($data["data"]);
                                echo "<script>var length;</script>";
                                echo "<script>length = " . $length . ";</script>";
                                echo "<script>var id = [];</script>";
                                echo "<script>var username = [];</script>";
                                echo "<script>var surname = [];</script>";
                                echo "<script>var phone = [];</script>";
                                echo "<script>var email = [];</script>";
                                echo "<script>var bday = [];</script>";
                                echo "<script>var genre = [];</script>";
                                echo "<script>var img = [];</script>";
                                for ($i = 0; $i < $length; $i++)
                                {
                                    echo "<script>id[" . $i . "] = '" . $data["data"][$i]["id"] . "';</script>";
                                    echo "<script>username[" . $i . "] = '" . $data["data"][$i]["name"] . "';</script>";
                                    echo "<script>surname[" . $i . "] = '" . $data["data"][$i]["surname"] . "';</script>";
                                    echo "<script>phone[" . $i . "] = '" . $data["data"][$i]["phone"] . "';</script>";
                                    echo "<script>email[" . $i . "] = '" . $data["data"][$i]["email"] . "';</script>";
                                    echo "<script>bday[" . $i . "] = '" . $data["data"][$i]["bday"] . "';</script>";
                                    echo "<script>genre[" . $i . "] = '" . $data["data"][$i]["gender"] . "';</script>";
                                    echo "<script>img[" . $i . "] = '" . $data["data"][$i]["path"] . "';</script>";
                                }
                                ?>
                                <div id="table"></div>
                                <br>
                                <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="javascript:prev()" id="prev" class="btn btn-danger btn-lg">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="javascript:next()" id="next" class="btn btn-primary btn-lg">Siguientes Resultados</button><br>
                                <script>change(1, 5, length);</script>
                                <?php
                            }
                            else //  Si la respuesta tiene el código de estado distinto de 200
                            {
                                echo "<h3 class='red'>" . $data["message"] . "</h3>"; // Muestro la respuesta del servicio, normalmente no hay datos en la base de datos aun.
                            }
                        }
                    }
                    ?>
                </div>
                <div id="view3">
                    <br><br><br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Tercer Servicio UPDATE - Modifica Datos de un Usuario Previo Login de Usuario</h2>
                            <form action="" method="post">
                            <label><input type="email" name="email" required> E-mail de Usuario</label>
                            <br><br>
                            <label><input type="password" name="pass" required> Contraseña</label>
                            <br><br>
                            <input type="submit" name="login" value="Login"  class="btn btn-secondary btn-lg">
                            </form>
                            <small><a href="forget.php">Olvidé mi Contraseña</a></small>
                            <br><br>
                            <?php
                            if (isset($_POST["login"])) // Si llegó la solicitud de login.
                            {
                                session_unset(); // Rompo la sesión.
                                if ($data["status"] == 200) // Si el código de estado es 200
                                {
                                    $id = $data["data"][0];
                                    $name = $data["data"][1];
                                    $surname = $data["data"][2];
                                    $phone = $data["data"][3];
                                    $email = $data["data"][4];
                                    $pass = $data["data"][5];
                                    $bday = $data["data"][6];
                                    $date = date('Y-m-d', strtotime($bday));
                                    $gender = $data["data"][7];
                                    $path = $data["data"][8];
                                    echo "<h3 class='blue'>" . $data["message"] . $name . "</h3>"; // Muestro los resultados con la foto del usuario.
                                    echo "<img src='" . $data['data'][8] . "' alt='Imagen de Perfil' width='320' height='240'><br><br>";
                                    echo "<button onclick='showIt()' class='btn btn-warning btn-lg'>Modifica Mis Datos</button>"; // Muestro el botón para mostrar el formulario con los datos del usuario a modificar.
                                }
                                else
                                {
                                    echo "<h3 class='red'>" . $data["message"] . $data["data"] . "</h3>"; // Si el código de estado no es 200 la ID no existe en la base de datos.
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-6 part" id="update" style="visibility: hidden;">
                            <h2>Modifica los Datos de un Usuario</h2>
                            <br>
                            <?php // Muestro el formulario con los datos del usuario a modificar.
                            echo '<form action="" method="post" enctype="multipart/form-data" onsubmit="return verify(2)">
                                <label><input type="hidden" name="id" value="' . $id . '"> ID del Usuario = ' . $id . '</label>
                                <br><br>
                                <label><input type="text" name="username" value="' . $name . '" required> Nombre del Usuario.</label>
                                <br><br>
                                <label><input type="text" name="surname" value="' . $surname . '" required> Apellidos del Usuario.</label>
                                <br><br>
                                <label><input type="number" name="phone" value="' . $phone . '" required> Teléfono del Usuario.</label>
                                <br><br>
                                <label><input type="email" name="email" value="' . $email . '" required> E-mail del Usuario.</label>
                                <br><br>
                                <label><input type="password" id="pass3" name="pass" value="' . $pass . '" required> Contraseña</label>
                                <br><br>
                                <label><input type="password" id="pass4" value="' . $pass . '" required> Repite Contraseña</label>
                                <br><br>
                                <label><input type="date" name="bday" value="' . $date . '" required> Fecha de Nacimiento</label>
                                <br><br>';
                                if ($gender == 0)
                                {
                                    echo '<label><input type="radio" name="gender" value="0" checked> Mujer</label>
                                    <br><br>
                                    <label><input type="radio" name="gender" value="1"> Varón</label>
                                    <br><br>';
                                }
                                else
                                {
                                    echo '<label><input type="radio" name="gender" value="0" > Mujer</label>
                                    <br><br>
                                    <label><input type="radio" name="gender" value="1" checked> Varón</label>
                                    <br><br>';
                                }
                                echo '<label><input type="file" name="profile" class="btn btn-primary btn-lg"> Foto de Perfil<small>(opcional)</small></label>
                                <input type="hidden" name="path" value="' . $path . '">
                                <br><br>
                                <input type="submit" name="update" value="Modifica Usuario" class="btn btn-info btn-lg">
                            </form>';
                            ?>
                        </div>
                        <?php
                            if (isset($_POST["update"])) // Si llega una solicitud de modificar
                            {
                                session_unset(); // Rompo la sesión
                                echo "<h3 class='blue'>" . $data["message"] . $data["data"] . "</h3>"; // Muestro los resultados.
                            }
                        ?>
                    </div>
                </div>
                <div id="view4">
                    <br><br><br><br>
                    <h2>Cuarto Servicio DELETE - Borra un Usuario</h2>
                    <form action="" method="post">
                        <label><input type="number" name="id" required> ID del Usuario a Borrar.</label>
                        <br><br>
                        <input type="submit" name="delete" value="Borra Usuario">
                    </form>
                    <br><br>
                    <?php
                    if (isset($_POST["delete"])) // Si llega una solicitud delete
                    {
                        session_unset(); // Rompo la sesión
                        echo "<h3 class='red'>" . $data["message"] . $data["data"] . "</h3>"; // Muestro los resultados.
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