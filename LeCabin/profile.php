<?php
include "includes/conn.php";
$title = "Salón de Estética Le Cabín - Perfil de Cliente";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["email"])) // Si se recibe el email del cliente
{
    $ok = false; // Booleano para verificar si los datos son correctos.
    $email = $_POST["email"]; // Lo asigno a la variable $email.
    $pass = $_POST["pass"]; // Asigno la Password a la variable $pass.
    $sql = "SELECT * FROM client WHERE email='$email';"; // Preparo la consulta con el email.
    $stmt = $conn->prepare($sql); // Hago la consulta a la base de datos con la conexión y la consulta recibidas.
    $stmt->execute(); // La ejecuto.
    if ($stmt->rowCount() > 0) // Si hubo resultados.
    {
        $row = $stmt->fetch(PDO::FETCH_OBJ); // Cargo el resultado en $row.
        if (password_verify($pass, $row->pass)) // Verifico la contraseña enviada con la de la base de datos descifrada.
        {
            $id = $row->id; // Si la contraseña es correcta, obtengo la ID del cliente.
            $name = $row->name; // Obtengo el nombre del cliente.
            $ok = true; // Pongo $ok a true.
        }
    }
    if ($ok) // Si $ok esta a true.
    {
        $_SESSION["client"] = $id; // Asigno a la variable de sesión client la id del cliente.
        $_SESSION["name"] = $name; // Asigno a la variable de sesión name el nombre del cliente.
    }
    else // Si $ok es false.
    {
        session_destroy(); // Destruyo la sesión.
    }
}

if (isset($_SESSION["client"])) // Verifico si la sesión no está vacia.
{
    $id = $_SESSION["client"]; // Asigno a la variable $id el valor de la sesión client.
    $sql = "SELECT * FROM clients WHERE id=$id;"; // Preparo una consulta por la ID.
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ); // Asigno el resultado a la variable $row.
    $name = $row->name; // Asigno el contenido de $row a variables.
    $address = $row->address;
    $phone = $row->phone;
    $email = $row->email;
    $bday = $row->bday;
    $b_day = strtotime($bday);
    $bday = date("Y-m-d", $b_day);
}
else
{
    echo "<script>toast(1, 'Ha Habido un Error', 'Has Llegado Aquí por Error.');</script>"; // Error, has llegado por el camino equivocado.
}
// Muestro el formulario con los datos del cliente por si quiere modificar o eliminar su perfil.
include "includes/nav_profile.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <br><br><br>
                <div class="row">
                    <div class="col-md-6">
                        <br>
                        <h2>Aquí Podrás Modificar tus Datos.</h2>
                        <br>
                        <h3><span style="color: red; font-size: 1.5rem;">Atención: </span> por razones de seguridad la Contraseña no se muestra, si no quieres cambiarla deja ambas casillas en blanco y se mantendrá la contraseña que tenías.</h3>
                        <br>
                        <form action='modify.php' method='post' onsubmit='return verify()'>
                        <label><input type='text' name='username' value='<?php echo $name; ?>' required> Nombre Completo</label>
                        <br><br>
                        <label><input type='text' name='address' value='<?php echo $address; ?>' required> Dirección</label>
                        <br><br>
                        <label><input type='text' name='phone' value='<?php echo $phone; ?>' required> Teléfono</label>
                        <br><br>
                        <label><input type='email' name='email' value='<?php echo $email; ?>' required> E-mail</label>
                        <br><br>
                        <label><input type='date' name='bday' value='<?php echo $bday; ?>' required> Cumpleaños</label>
                        <br><br>
                        <label><input type='password' name='pass' id='pass1' onkeypress="showEye(1)"> Contraseña</label>
                        <i onclick="spy(1)" class="far fa-eye" id="togglePassword1" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                        <br><br>
                        <label><input type='password' id='pass2' onkeypress="showEye(2)"> Repite Contraseña</label>
                        <i onclick="spy(2)" class="far fa-eye" id="togglePassword2" style="margin-left: -205px; cursor: pointer; visibility: hidden;"></i>
                        <br><br>
                        <input type='submit' value='Modificar'>
                        </form>
                    </div>
                    <div class="col-md-1" style="border: 1px solid grey; width: 1%;"></div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>O Eliminar tu Perfil</h2>
                                <br><br><br>
                                <form action="delete.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" value="Elimino Mi Perfil">
                                </form>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Tu Cita:</h2>
                                <br>
                                <?php
                                $sql = "SELECT date, time FROM client WHERE id=$id;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute(); // Hago una consulta a la base de datos de los datos del alumno y los cursos.
                                if ($stmt->rowCount() > 0) // Si hay resultados.
                                {
                                    $row = $stmt->fetch(PDO::FETCH_OBJ); // Asigno los resultados a $row.
                                    $my_date = explode("-", $row->date);
                                    echo "<h4>Tienes Cita el día: " . $my_date[2] . "/" . $my_date[1] . "/" . $my_date[0] . " a las " . $row->time . " Hs.</h4>"; // Muestro la cita.
                                }
                                ?>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Tus Compras:</h2>
                                <br>
                            <?php
                                $ok = false;
                                $i = 0;
                                $sql = "SELECT * FROM client INNER JOIN invoice, service WHERE client.id=$id AND client.id=invoice.client_id AND service.id=invoice.service_id;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute(); // Hago una consulta a la base de datos de los datos del alumno y los cursos.
                                if ($stmt->rowCount() > 0) // Si hay resultados declaro las variables.
                                {
                                    $ok = true;

                                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo los datos en $row.
                                    {
                                        $name = $row->name; // Asigno los datos a sus variables.
                                        $service[$i] = $row->service;
                                        $price[$i] = $row->price;
                                        $qtty[$i] = $row->qtty;
                                        $total[$i] = $row->total;
                                        $date[$i] = $row->date;
                                        $time[$i] = $row->time;
                                        $i++;
                                    }
                                }
                                else // Si no hay datos
                                {
                                    echo "<script>toast(1, 'Aun sin Datos', 'No Hay Ningún Dato Tuyo Registrado.');</script>"; // No hay Registros.
                                }
                                if ($ok) // Si se encontró el alumno.
                                {
                                    echo "<script>var name = '';</script>"; // Declaro las variavbles de Javascript que usará la paginación.
                                    echo "<script>var service = [];</script>";
                                    echo "<script>var price = [];</script>";
                                    echo "<script>var qtties = [];</script>";
                                    echo "<script>var total = [];</script>";
                                    echo "<script>var date = [];</script>";
                                    echo "<script>var time = [];</script>";
                                    echo "<script>name = '" . $name . "';</script>"; // Les asigno los datos de PHP.
                                    for ($i = 0; $i < count($service); $i++)
                                    {
                                        echo "<script>service[" . $i . "] = '" . $service[$i] . "';</script>";
                                        echo "<script>price[" . $i . "] = '" . $price[$i] . "';</script>";
                                        echo "<script>qtties[" . $i . "] = '" . $qtty[$i] . "';</script>";
                                        echo "<script>total[" . $i . "] = '" . $total[$i] . "';</script>";
                                        echo "<script>date[" . $i . "] = '" . $date[$i] . "';</script>";
                                        echo "<script>time[" . $i . "] = '" . $time[$i] . "';</script>";
                                    }
                                    ?>
                                    <div id="table"></div>
                                    <br>
                                    <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button onclick="prev('profile')" id="prev" class="btn btn-danger" style="visibility: hidden;">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button onclick="next('profile')" id="next" class="btn btn-primary" style="visibility: hidden;">Siguientes Resultados</button><br>
                                    <script>change(1, 5, 'profile');</script>
                                    <?php
                                    // Aquí aproveché el código que tenía de la paginación aunque en este caso solo muestro un resultado, el curso en el que está el alumno.
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>