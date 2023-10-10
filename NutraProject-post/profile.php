<?php
include "includes/conn.php";

function getIt($conn, $i, $k, $productArray) // Función getIt(), recibe los parametros necesarios, la conexión con la base de datos $conn, los índices $i y $k y el array $serviceArray.
{
    global $product; // Hago glabales las variables $service y $price para poder usarlas sin pasarlas como referencia.
    global $price;
    $product[] = []; // Al array $service le asigno un array (doble array).
    $price[] = [];
    $sql = "SELECT product, price FROM product WHERE " . $productArray[$i][$k] . "=id"; // Hago una consulta a la base de datos para obtener el nombre de los servicios y los precios, comparando las id de los servicios con las id almacenadas en el array $serviceArray usando los índices que también llegan como parametro.
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) // Si hay resultados.
    {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo los datos en $row.
        {
            array_push($product[$i], $row->product . "<br>"); // Hago un push del contenido del campo service, el nombre del servicio, en el array $service en el índice que corresponda, $i.
            array_push($price[$i], $row->price . " €<br>"); // Hago un push del contenido del campo price, el precio del servicio, en el array $price. en el índice que corresponda, $i.
        }
    }
}

if (isset($_POST["email"])) // Si se recibe el email del cliente
{
    $ok = false; // Booleano para verificar si los datos son correctos.
    $email = htmlspecialchars($_POST["email"]); // Lo asigno a la variable $email.
    $array = explode("@", $email); // Exploto en el array $array el email por la @
    if (file_exists($array[0] . "login.txt")) // Si existe el archivo.
    {
        unlink($array[0] . "login.txt"); // Lo borro.
    }
    $pass = htmlspecialchars($_POST["pass"]); // Asigno la Password a la variable $pass.
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

$title = "Nutra Project - Perfil de Cliente";
include "includes/header.php";

if (isset($_SESSION["client"]) && $_SESSION["client"] > 0) // Verifico si la sesión no está vacia.
{
    include "includes/modal.html";
    $id = $_SESSION["client"]; // Asigno a la variable $id el valor de la sesión client.
    $sql = "SELECT * FROM client WHERE id=$id"; // Preparo una consulta por la ID.
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
    include "includes/nav-profile.php";
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
                        <label><input type='text' name='username' value='<?php echo $name; ?>' required> Tu Nombre</label>
                        <br><br>
                        <label><input type='text' name='surname' value='<?php echo $name; ?>' required> Apellido 1</label>
                        <br><br>
                        <label><input type='text' name='surname2' value='<?php echo $name; ?>'> Apellido 2</label>
                        <br><br>
                        <label><input type='text' name='address' value='<?php echo $address; ?>' required> Dirección</label>
                        <br><br>
                        <label><input type='text' name='phone' value='<?php echo $phone; ?>' required> Teléfono</label>
                        <br><br>
                        <label><input type='email' name='email' value='<?php echo $email; ?>' required> E-mail</label>
                        <br><br>
                        <label><input type='date' name='bday' value='<?php echo $bday; ?>' required> Cumpleaños</label>
                        <br><br>
                        <label><input type='password' name='pass' id='pass0' onkeypress="showEye(0)"> Contraseña</label>
                        <i onclick="spy(0)" class="far fa-eye" id="togglePassword0" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                        <br><br>
                        <label><input type='password' id='pass1' onkeypress="showEye(1)"> Repite Contraseña</label>
                        <i onclick="spy(1)" class="far fa-eye" id="togglePassword1" style="margin-left: -205px; cursor: pointer; visibility: hidden;"></i>
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
                                <form action="delete_client.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" value="Elimino Mi Perfil">
                                </form>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Tus Compras</h2>
                                <br><br>
                            <?php
                                $product = [];
                                $price = [];
                                $i = 0;
                                $firstsql = "SELECT product_id FROM invoice WHERE client_id=$id";
                                $stmt = $conn->prepare($firstsql);
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) // Si hay resultados declaro las variables.
                                {
                                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo los datos en $row.
                                    {
                                        $product_id = $row->product_id;
                                        $productArray[$i] = explode(',', $product_id);
                                        $i++;
                                    }

                                    for ($i = 0; $i < count($productArray); $i++) // Hago un doble bucle cuento el tamaño del array por fuera.
                                    {
                                        $arrayCount[$i] = count($productArray[$i]) - 1; // Guardo en el array arrayCount el tamaño de cada array, se descuenta 1 ya que siempre hay una coma al final de la cadena y la cuenta como un valor más.
                                        for ($j = 0; $j < $arrayCount[$i]; $j++)
                                        {
                                            getIt($conn, $i, $j, $productArray);
                                        }
                                    }
                                    $ok = false;
                                    $k = 0;
                                    $sql = "SELECT * FROM client INNER JOIN invoice ON client.id=invoice.client_id WHERE client.id=$id;";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute(); // Hago una consulta a la base de datos de los datos del cliente y sus facturas.
                                    if ($stmt->rowCount() > 0) // Si hay resultados declaro las variables.
                                    {
                                        $ok = true;

                                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo los datos en $row.
                                        {
                                            $name = $row->name; // Asigno los datos a sus variables.
                                            $qtty[$k] = $row->qtty;
                                            $total[$k] = $row->total;
                                            $date[$k] = $row->date;
                                            $time[$k] = $row->time;
                                            $k++;
                                        }
                                    }
                                }
                                else
                                {
                                    $ok = false;
                                    echo "<script>toast(1, 'Aun sin Datos', 'No Hay Ningúna Factura Tuya Registrada.');</script>"; // No hay Registros.
                                }
                                
                                if ($ok) // Si se encontró el alumno.
                                {
                                    echo "<script>var name = '';</script>"; // Declaro las variavbles de Javascript que usará la paginación.
                                    echo "<script>var product = [];</script>";
                                    echo "<script>var price = [];</script>";
                                    echo "<script>var qtties = [];</script>";
                                    echo "<script>var total = [];</script>";
                                    echo "<script>var date = [];</script>";
                                    echo "<script>var time = [];</script>";
                                    echo "<script>name = '" . $name . "';</script>"; // Les asigno los datos de PHP.
                                    for ($i = 0; $i < count($total); $i++)
                                    {
                                        echo "<script>qtties[" . $i . "] = '" . $qtty[$i] . "';</script>";
                                        echo "<script>total[" . $i . "] = '" . $total[$i] . "';</script>";
                                        echo "<script>date[" . $i . "] = '" . $date[$i] . "';</script>";
                                        echo "<script>time[" . $i . "] = '" . $time[$i] . "';</script>";
                                        echo "<script>product[" . $i . "] = '';</script>";
                                        echo "<script>price[" . $i . "] = '';</script>";
                                        for ($j = 0; $j < count($product[$i]); $j++) // Bucle interno desde 0 al tamaño del array $service[$i] en el indice $i.
                                        {
                                            echo "<script>product[" . $i . "] += '" . $product[$i][$j] . "';</script>"; // Muestro el contenido del doble array $service.
                                            echo "<script>price[" . $i . "] += '" . $price[$i][$j] . "';</script>";
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
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/js/bootstrap.min.js" integrity="sha512-5BqtYqlWfJemW5+v+TZUs22uigI8tXeVah5S/1Z6qBLVO7gakAOtkOzUtgq6dsIo5c0NJdmGPs0H9I+2OHUHVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
    <div id="view1">
    <div id="pc"></div>
	<div id="mobile"></div>
    </div>
    <?php
    include "includes/modal-index.html";
    echo "<script>toast(1, 'Ha Habido un Error', 'Has Llegado Aquí por Error.');</script>"; // Error, has llegado por el camino equivocado.
}
// Muestro el formulario con los datos del cliente por si quiere modificar o eliminar su perfil.
include "includes/footer.html";
?>
