<?php
include "includes/conn.php";
include "getdata.php";

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

$title = "La Peluquería de Javier Borneo - Perfil de Cliente";
include "includes/header.php";

if (isset($_SESSION["client"])) // Verifico si la sesión no está vacia.
{
    include "includes/modal.html";
    $id = $_SESSION["client"]; // Asigno a la variable $id el valor de la sesión client.
    $sql = "SELECT * FROM client WHERE id=$id;"; // Preparo una consulta por la ID.
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
    include "includes/nav_profile.php";
    include "includes/nav-mob-profile.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <br><br><br>
                <div class="row">
                    <div class="col-md-5">
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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
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
                            <div class="col-md-12">
                                <h2>Tu Turno:</h2>
                                <br>
                                <?php
                                $sql = "SELECT date, time FROM client WHERE id=$id;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute(); // Hago una consulta a la base de datos de los datos de la fecha y la hora.
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
                            <div class="col-md-12">
                                <h2>Tus Compras</h2>
                                <br><br>
                            <?php
                            $index = 0;
                            $ids = [];
                            $array = [];
                            $qtty = [];
                            $service = [];
                            $service[] = [];
                            $price = [];
                            $price[] = [];

                            $sql = "SELECT invoice_id FROM sold JOIN invoice ON sold.invoice_id=invoice.id WHERE invoice.client_id=$id GROUP BY invoice_id;";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                $ok = true;
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    $ids[$index] = $row->invoice_id;
                                    $index++;
                                }
                                $index = 0;
                                $sql = "SELECT invoice_id, invoice.total, invoice.inv_date, invoice.inv_time FROM sold JOIN invoice ON sold.invoice_id=invoice.id WHERE invoice.client_id=$id GROUP BY invoice_id;";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    $total[$index] = $row->total;
                                    $date[$index] = $row->inv_date;
                                    $time[$index] = $row->inv_time;
                                    $index++;
                                }
                                $index = 0;
                                $array[] = [];
                                $qtty[] = [];
                                $sql = "SELECT * FROM sold INNER JOIN invoice WHERE invoice.client_id=$id AND invoice.id=sold.invoice_id;";
                                $stmt_sold = $conn->prepare($sql);
                                $stmt_sold->execute();
                                $ids2 = [];
                                $serv = [];
                                $qtt = [];
                                while ($row_sold = $stmt_sold->fetch(PDO::FETCH_OBJ))
                                {
                                    $ids2[$index] = $row_sold->invoice_id;
                                    $serv[$index] = $row_sold->service_id;
                                    $qtt[$index] = $row_sold->qtty . "<br>";
                                    $index++;
                                }
                                $i = 0;
                                $index = 0;
                                for ($z = 0; $z < count($ids); $z++)
                                {
                                    recursive($index, $serv, $qtt, $ids2, $i);
                                    $i++;
                                    $index++;
                                }
                                getService($conn, $array, "html");
                            }
                            else // Si no hay datos
                            {
                                echo "<script>toast(1, 'Aun sin Datos', 'No Hay Ningúna Factura Tuya Registrada.');</script>"; // No hay Registros.
                            }
                            if ($ok) // Si se encontraron facturas.
                            {
                                echo "<script>var name = '';</script>
                                <script>var invoice = [];</script>
                                <script>var service = [];</script>
                                <script>var price = [];</script>
                                <script>var qtties = [];</script>
                                <script>var total = [];</script>
                                <script>var date = [];</script>
                                <script>var time = [];</script>
                                <script>name = '" . $name . "';</script>"; // Les asigno los datos de PHP.
                                for ($i = 0; $i < count($ids); $i++)
                                {
                                    echo "<script>invoice[" . $i . "] = " . $ids[$i] . ";</script>
                                    <script>total[" . $i . "] = '" . $total[$i] . "';</script>
                                    <script>date[" . $i . "] = '" . $date[$i] . "';</script>
                                    <script>time[" . $i . "] = '" . $time[$i] . "';</script>";
                                }
                                for ($i = 0; $i < count($service); $i++) // Bucle interno desde 0 al tamaño del doble array $service.
                                {
                                    echo "<script> service[" . $i . "] = [];
                                    price[" . $i . "] = [];
                                    qtties[" . $i . "] = [];</script>";
                                    for ($j = 0; $j < count($service[$i]); $j++)
                                    {
                                        echo "<script>qtties[" . $i . "][" . $j . "] = '" . $qtty[$i][$j] . "';</script>
                                        <script>service[" . $i . "][" . $j . "] = '" . $service[$i][$j] . "';</script>
                                        <script>price[" . $i . "][" . $j . "] = '" . $price[$i][$j] . "';</script>";
                                    }
                                }
                                ?>
                                <div id="table"></div>
                                <br>
                                <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="prev('profile')" id="prev" class="btn btn-danger" style="visibility: hidden;">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="next('profile')" id="next" class="btn btn-primary" style="visibility: hidden;">Siguientes Resultados</button><br>
                                <script>change(1, 5, 'profile');</script>
                                <?php
                                // Se muestran las facturas del cliente.
                            }
                            ?>
                            <br><br><br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
</section>
<?php
}
else
{
    include "includes/modal_index.html";
    echo "<script>toast(1, 'Ha Habido un Error', 'Has Llegado Aquí por Error.');</script>"; // Error, has llegado por el camino equivocado.
}
include "includes/footer.html";
?>