<?php
include "includes/conn.php";
include "includes/modal-dismiss.html";

if (isset($_POST["invited"])) // Si la cita la reserva el administrador.
{
    $already = false;
    $name = "Consumidor Final";
    $address = "";
    $phone = "";
    $email = $_POST["invited"];
    $pass = "1111";
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $bday = "";
    $date = "";
    $time = "";

    $stmt = $conn->prepare("SELECT id, email FROM client"); // Busco los E-mail.
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        while($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            if ($email == $row->email) // Si está cuaquiera de los tres.
            {
                $_SESSION["client"] = $row->id;
                $_SESSION["name"] = $name;
                $already = true; // Pongo $already a true.
                break; // Salgo de la busqueda.
            }
        }
    }

    if (!$already) // Si no están en la base de datos ni E-mail ni Teléfono.
    {
        $stmt = $conn->prepare("INSERT INTO client VALUES (:id, :name, :address, :phone, :email, :pass, :bday, :date, :time);");

        $stmt->execute(array(':id' => null, ':name' => $name, ':address' => $address, ':phone' => $phone, ':email' => $email, ':pass' => $hash, ':bday' => $bday, ':date' => $date, ':time' => $time));

        $_SESSION["client"] = $conn->lastInsertId();
        $_SESSION["name"] = $name;
        echo "<script>toast(0, 'Cliente Agregado', 'Se Ha Registrado el Cliente $name.');</script>";
        // Inserto los datos y aviso.
    }
}
$title = "Citas a Clientes - La Peluquería de Javier Borneo";
include "includes/header.php";
include "includes/nav_request.php";
include "includes/nav-mob-request.php";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1" style="width: 5%;"></div>
            <div class="col-md-10">
                <div id="view1">
                <br><br><br><br>
                    <?php
                    if (isset($_SESSION["client"])) // Aquí entra si está abierta la sesión client.
                    {
                        $id = $_SESSION["client"];
                        if (!isset($_POST['date'])) // Si no se envió la fecha, vengo del perfil de un cliente.
                        {
                            echo '<h3 class="auto-style1"><strong>Te Damos la Bienvenida a la Peluquería de Javier Borneo.</strong></h3><br>';
                            
                            echo '<h4 class="auto-style1">Por Favor Pide tu Turno Usando el Calendario para Poder Atenderte.</h4><br>';
                            echo '<form method="post">';
                            echo '<label><input type="date" name="date" id="day" required> Selecciona el Día de tu Turno</label>';
                            echo '<br><br>';
                            echo '<input type="submit" value="Tocá aquí para Elegir la Hora." style="height:32px;">';
                            echo '</form>';
                            echo '<br><br>';
                        }
                        else // Si la fecha se envió vengo del script de administración.
                        {
                            $latin = "";
                            $date = $_POST['date'];
                            $preLatin = explode ("-", $date);
                            $reverse = array_reverse ($preLatin);
                            for ($i = 0; $i < count($reverse); $i++)
                            {
                                $latin .= $reverse[$i];
                                if ($i == 2)
                                {
                                    break;
                                }
                                $latin .= "-";
                            }
                            $z = 0;
                            $time_array = [];
                            $stmt = $conn->prepare("SELECT time FROM client WHERE date='$date'");
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    $time_array[$z] = $row->time;
                                    $z++;
                                }
                            }
                            
                            $index = 0; // Indice correlativo de los turnos.
                            $zero = 0; // Variable a 0 para los segundos.
                            $exist = false; // Booleano para avisar si el turno ya está reservado.
                            echo '<form action="turn.php" method="post">';
                            echo '<input type="hidden" name="id" value="' . $id . '">';
                            echo '<input type="text" value="' . $latin . '" readonly>';
                            echo '<input type="hidden" name="date" value="' . $date . '">';
                            echo '<br><br>';
                            echo '<label>Selecciona la Hora del Turno</label>';
                            echo '<br><br>';
                            for($hours = 9; $hours < 19; $hours++) // Horas de las Citas, de 9 a 19.
                            {
                                if ($hours < 13 || $hours > 14)
                                {
                                    for($mins = 0; $mins < 60; $mins += 30) // Minutos de las Citas, cada 30 minutos.
                                    {
                                        $turn_array[$index] = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT) . ':' . str_pad($zero, 2, '0', STR_PAD_LEFT); // Carga en un array las citas.
                                        for ($j = $index; $j < (count($time_array)) + $index; $j++) // Bucle para verificar si la cita ya está solicitada.
                                        {
                                            if ($turn_array[$index] == $time_array[$j - $index]) // Si la hora de la cita está en la base de datos
                                            {
                                                $exist = true; // Si es así pongo $exist a true, ya está solicitada.
                                                break; // Rompo el bucle.
                                            }
                                        }
                                        if (!$exist) // Si $exist está a false.
                                        {
                                            turns($turn_array[$index], ($index + 1), (($index + 1) . "i")); // Llama a la función turns. // Muestro la hora de la cita en pantalla, para poder seleccionarla.
                                        }
                                        else // Si ya está seleccionada
                                        {
                                            $exist = false; // Cambio el estado de $exist a false.
                                        }
                                        $index++; // Incremento el número de la cita.
                                    }
                                }
                            }
                            echo '<br><input type="submit" value="Solicitar Turno">';
                            echo '</form>';
                        }
                    }
                    else
                    {
                        echo "Donde estoy?";
                    }
                ?>
                </div>
            </div>
        <div class="col-md-1" style="width: 5%;"></div>
    </div>
</section>
<?php
function turns($turn, $id, $idi)
{
    if ($id > 9)
    {
        echo '<label id="' . $idi . '"><input type="radio" value="' . $turn . '" name="time" id="' . $id . '">Cita: ' . $id . ' -- ' . $turn . '</label><br>';
    }
    else
    {
        echo '<label id="' . $idi . '"><input type="radio" value="' . $turn . '" name="time" id="' . $id . '">Cita: ' . $id . ' --- ' . $turn . '</label><br>';
    }
}
include "includes/footer.html";
?>
<script>screenSize();</script>
<script>screen();</script>
<!-- Script para detectar si la pantalla modifica su tamaño horizontal -->
<script>
    window.addEventListener('resize', screen);
    screen();
</script>
</body>
</html>