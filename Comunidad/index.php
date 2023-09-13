<?php
include "includes/conn.php";
$title = "Administración Oliva";
include "includes/header.php";
include "includes/modal.html";
include "includes/nav-index.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
                    <h1>Comunidades</h1>
                    <br><br>
                    <?php
                        if (isset($_POST["finca"]) || isset($_SESSION["finca"]))
                        {
                            if(!isset($_POST["finca"]))
                            {
                                $id = $_SESSION["finca"];
                            }
                            else
                            {
                                $id = $_POST["finca"];
                            }
                            $_SESSION["finca"] = $id;
                            $result = getFinca($conn, $id);
                            echo '<h1>Haz Seleccionado la Comunidad de Propietarios: ' . $result . '</h1>
                            <button onclick="window.open(\'index.php#view2\', \'_self\')" class="btn btn-secondary btn-lg">Usa el Menú para Administrar esta Finca o Click AQUÍ para Pasar a la Siguiente Página.</button>
                            <br><br>
                            <button onclick="window.open(\'prop.php\', \'_self\')" class="btn btn-danger btn-lg">Agrego un Propietario de esta Comunidad</button>
                            <br><br>
                            <button onclick="window.open(\'clean.php\', \'_self\')" class="btn btn-info btn-lg">Selecciono otra Comunidad</button>
                            <br><br>
                            <button onclick="window.open(\'finca.php\', \'_self\')" class="btn btn-primary btn-lg">Agrego una Nueva Comunidad</button>';
                        }
                        else
                        {
                            echo '<h3>Para Empezar Selecciona la Comunidad de Propietarios a Administrar.</h3>
                                <br>
                                <form method="post">
                                <fieldset>
                                    <legend><h3>Selecciona la Comunidad de la Lista</h3></legend>
                                    <label><select name="finca" required>
                                        <option value="">Selecciona la Comunidad</option>';
                                        $sql = "SELECT * FROM finca";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                        {
                                            echo '<option value="' . $row->IDC . '">' . $row->name . '</option>';
                                        }
                                        
                                echo '</select> Comunidad de Propietarios</label>
                                <br><br>
                                <input type="submit" value="Esta Comunidad" class="btn btn-primary btn-lg">
                                </fieldset>
                                </form>
                                <br><br>
                                <br><br>
                                <button onclick="window.open(\'finca.php\', \'_self\')" class="btn btn-primary btn-lg">Agrego una Nueva Comunidad</button>
                            ';
                        }
                    ?>
                </div>
                <div id="view2">
                <br><br><br><br>
                    <h1>Horario de trabajo de los Empleados.</h1>
                    <br><br>
                    <?php
                        if (isset($_POST["finca"]) || isset($_SESSION["finca"]))
                        {
                            if(!isset($_POST["finca"]))
                            {
                                $idc = $_SESSION["finca"];
                            }
                            else
                            {
                                $idc = $_POST["finca"];
                            }
                            $name = [];
                            $surname = [];
                            $id = [];
                            $contract = [];
                            $i = getData($conn, $idc);
                            echo '<form action="time.php" method="post">
                                <input type="hidden" value="' . $idc . '">';
                            if ($i == 1)
                            {
                                echo '
                                    <label><input type="radio" name="employee" checked>' . $name[0] . " " . $surname[0] . ', Contrato ' . $contract[0] . '</label>
                                    <br><br>
                                    <input type="hidden" name="id" value="' . $id[0] . '">
                                    <br><br>
                                ';
                                formEmployee();
                            }
                            else
                            {
                                if ($i > 0)
                                {
                                    echo '
                                        <label><input type="radio" name="employee"> ' . $name[0] . " " . $surname[0] . ', Contrato ' . $contract[0] . '</label>
                                        <br><br>
                                        <input type="hidden" name="id" value="' . $id[0] . '">
                                        <br><br>
                                        <label><input type="radio" name="employee" checked> ' . $name[1] . " " . $surname[1] . ', Contrato ' . $contract[1] . '</label>
                                        <br><br>
                                        <input type="hidden" name="id" value="' . $id[1] . '">
                                        <br><br>
                                    ';
                                    formEmployee();
                                }
                                else
                                {
                                    echo '<h3>Aun no hay Empleados trabajando en esta Comunidad.</h3>';
                                }
                            }
                        }
                        else
                        {
                            echo '<h3>Por Favor Selecciona Primero una Comunidad de Propietarios en La Página Anterior.</h3>';
                        }
                    ?>
                </div>
                <div id="view3">
                <br><br><br><br>
                    <h3>Administración de Empleados</h3>
                    <br><br>
                    <?php
                    if (isset($_POST["finca"]) || isset($_SESSION["finca"]))
                    {
                        if(!isset($_POST["finca"]))
                        {
                            $idc = $_SESSION["finca"];
                        }
                        else
                        {
                            $idc = $_POST["finca"];
                        }
                        $name = [];
                        $surname = [];
                        $id = [];
                        $contract = [];
                        $alta = [];
                        $i = getData($conn, $idc);
                        echo '';
                        if ($i == 1)
                        {
                            echo '<form action="modify.php" method="post">
                            <table><tr><th>Nombre</th><th>Apellido</th><th>Contrato</th><th>Modificar</th><th>Dar de Baja</th><th>Borrar</th></tr><tr>
                            <td><input type="text" name="employee" value="' . $name[0] . '" readonly></td>
                            <td><input type="text" name="surname" value="' . $surname[0] . '" readonly></td>
                            <td><input type="text" name="contract" value="' . $contract[0] . '" readonly></td>
                            <td><input type="submit" class="btn btn-primary btn-lg" name="modify" value="Modificar"></td>
                            <td><input type="submit" class="btn btn-info btn-lg" name="baja" value="Baja"></td>
                            <td><input type="submit" class="btn btn-danger btn-lg" name="borrar" value="Borrar"></td>
                            <input type="hidden" name="id" value="' . $id[0] . '"></tr></table>
                            </form>';
                        }
                        else
                        {
                            if ($i > 0)
                            {
                                echo '<form action="modify.php" method="post">
                                <table><tr><th>Nombre</th><th>Apellido</th><th>Contrato</th><th>Modificar</th><th>Dar de Baja</th><th>Borrar</th></tr><tr>
                                <td><input type="text" name="employee" value="' . $name[0] . '" readonly></td>
                                <td><input type="text" name="surname" value="' . $surname[0] . '" readonly></td>
                                <td><input type="text" name="contract" value="' . $contract[0] . '" readonly></td>
                                <td><input type="submit" class="btn btn-primary btn-lg" name="modify" value="Modificar"></td>
                                <td><input type="submit" class="btn btn-info btn-lg" name="baja" value="Baja"></td>
                                <td><input type="submit" class="btn btn-danger btn-lg" name="borrar" value="Borrar"></td>
                                <input type="hidden" name="id" value="' . $id[0] . '">';
                                if ($alta[1])
                                {
                                    echo '</tr><tr><td><input type="text" name="employee1" value="' . $name[1] . '" readonly></td>
                                        <td><input type="text" name="surname1" value="' . $surname[1] . '" readonly></td>
                                        <td><input type="text" name="contract1" value="' . $contract[1] . '" readonly></td>
                                        <td><input type="submit" class="btn btn-primary btn-lg" name="modify1" value="Modificar"></td>
                                        <td><input type="submit" class="btn btn-info btn-lg" name="baja1" value="Baja"></td>
                                        <td><input type="submit" class="btn btn-danger btn-lg" name="borrar1" value="Borrar"></td>
                                        <input type="hidden" name="id1" value="' . $id[1] . '">';
                                }
                                echo '</tr></table>
                                </form>';
                            }
                            else
                            {
                                echo '<h3>Aun no hay Empleados trabajando en esta Comunidad. Si tiene Algún Trabajador, Agregalo Haciendo Click en el Botón de Abajo.</h3>';
                            }
                        }
                        echo '<br><br>
                        <button onclick="window.open(\'add.php?idc=<?php echo $idc; ?>\', \'_self\')" class="btn btn-secondary btn-lg">Agrego un Empleado</button>';
                    }
                    else
                    {
                        echo '<h3>Por Favor Selecciona Primero una Comunidad de Propietarios en La Página Anterior.</h3>';
                    }
                    ?>
                </div>
                <div id="view4">
                <br><br><br><br>
                <?php
                if (isset($_POST["finca"]) || isset($_SESSION["finca"]))
                {
                    if(!isset($_POST["finca"]))
                    {
                        $idc = $_SESSION["finca"];
                    }
                    else
                    {
                        $idc = $_POST["finca"];
                    }
                    $pool = getPool($conn, $idc);
                    if ($pool)
                    {
                        echo '<h1>Control PH y Cloro Piscina</h1>
                        <br><br>
                        <form action="pool.php" method="post">
                        <fieldset>
                            <legend><h3>Control Diario del PH y el Cloro del Agua de la Piscina.</h3></legend>
                            <br>
                            <input type="hidden" name="pool" value="' . $pool . '">
                            <label><input type="date" name="date" required> Día de la Muestra<span class="red">*</span></label>
                            <br><br>
                            <label><input type="time" name="time" required> Hora de la Muestra<span class="red">*</span></label>
                            <br><br>
                            <fieldset>
                                <legend><h4>Espuma Grasas y Materias.</h4></legend>
                                <label><input type="radio" name="espuma" value="0" checked> Sin Espuma, Grasas ni Materias</label>
                                <br><br>
                                <label><input type="radio" name="espuma" value="1"> Se Observa: Espuma, Grasas y Materias</label>
                                <br>
                            </fieldset>
                            <br>
                            <fieldset>
                                <legend><h4>Transparencias.</h4></legend>
                                <label><input type="radio" name="transparency" value="1" checked> Transparente</label>
                                <br><br>
                                <label><input type="radio" name="transparency" vlaue="0"> Falta de Transparencia</label>
                                <br>
                            </fieldset>
                            <br>
                            <label><input type="text" name="turbia"> Turbidez (no requerido)</label>
                            <br><br>
                            <label><input type="text" name="ph" required> PH<span class="red">*</span></label>
                            <br><br>
                            <label><input type="text" name="cl_libre" required> Cloro Libre Residual<span class="red">*</span></label>
                            <br><br>
                            <label><input type="text" name="cl_comby" required> Cloro Combinado Residual<span class="red">*</span></label>
                            <br><br>
                            <label><input type="text" name="temp_agua"> Temperatura del Agua (no requerido)</label>
                            <br><br>
                            <label><input type="text" name="temp_amb"> Temperatura Ambiente (no requerido)</label>
                            <br><br>
                            <label><input type="text" name="hum_relativa"> Humedad Relativa (no requerido)</label>
                            <br><br>
                            <label><input type="text" name="co2"> CO2 (no requerido)</label>
                            <br><br>
                            <label><input type="text" name="recirculacion"> Tiempo de Recirculación<span class="red">*</span></label>
                            <br><br>
                            <label><input type="text" name="control"> Control del Inspector Sanitario</label>
                            <br><br>
                            <label><textarea name="obs" cols="40" rows="6"></textarea> Observaciones</label>
                            <br><br>
                            <input type="submit" value="Almacenar estos Datos" class="btn btn-primary btn-lg">
                        </fieldset>
                        </form>';
                    }
                    else
                    {
                        echo '<h3>Esta Comunidad no Tiene Piscina.</h3>';
                    }
                }
                else
                {
                    echo '<h3>Por Favor Selecciona Primero una Comunidad de Propietarios en La Página Anterior.</h3>';
                }
                ?>
                </div>
                <div id="view5">
                    <br><br><br><br>
                    <h1>Lectura de Contadores de Agua Fria y Caliente</h1>
                    <br><br>
                    <?php
                        if (isset($_POST["finca"]) || isset($_SESSION["finca"]))
                        {
                            if(!isset($_POST["finca"]))
                            {
                                $idc = $_SESSION["finca"];
                            }
                            else
                            {
                                $idc = $_POST["finca"];
                            }
                            echo '<form action="water.php" method="post">
                            <fieldset>
                                <legend><h4>Lectura de Contadores de Agua</h4></legend>
                                <br>
                                <label><select name="owner" required>
                                    <option value="">Selecciona Piso</option>';
                                    $sql = "SELECT * FROM propietario WHERE idc=$idc;";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    if ($stmt->rowCount() > 0)
                                    {
                                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                        {
                                            echo '<option value="' . $row->ID_owner . '">' . $row->apartment . '</option>';
                                        }
                                    }
                                echo '</select> Seleciona el Número de Piso</label>
                                <br><br>
                                <label><input type="date" name="fecha" required> Fecha de Control</label>
                                <br><br>
                                <label><input type="number" name="cold" required> Agua Fria</label>
                                <br><br>
                                <label><input type="number" name="hot" required> Agua Caliente</label>
                                <br><br>
                                <input type="submit" value="Registro el Consumo de Agua">
                            </fieldset>
                            </form>';
                        }
                        else
                        {
                            echo '<h3>Por Favor Selecciona Primero una Comunidad de Propietarios en La Página Anterior.</h3>';
                        }
                    ?>
                </div>
                <div id="view6">
                <br><br><br><br>
                    <h1>Contacto con los Trabajadores</h1>
                    <br><br>
                </div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
function getFinca($conn, $idc)
{
    $sql = "SELECT name FROM finca WHERE IDC=$idc;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    return $row->name;
}

function getData($conn, $idc)
{
    global $name, $surname, $id, $contract, $alta;
    $i = 0;
    $sql = "SELECT * FROM empleado WHERE idc=$idc;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
            $id[$i] = $row->ID;
            $name[$i] = $row->name;
            $surname[$i] = $row->surname1;
            $contract[$i] = $row->contract;
            $alta[$i] = $row->alta;
            $i++;
        }
    }
    return $i;
}

function getPool($conn, $idc)
{
    $sql = "SELECT pool FROM finca WHERE idc=$idc;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    return $row->pool;
}

function formEmployee()
{
    echo '<label><input type="time" name="morn_in" required> Hora de Comienzo a la Mañana</label>
        <br><br>
        <label><input type="time" name="morn_out" required> Hora de Salida a la Mañana</label>
        <br><br>
        <label><input type="time" name="noon_in" required> Hora de Comienzo a la Tarde</label>
        <br><br>
        <label><input type="time" name="noon_out" required> Hora de Salida a la Tarde</label>
        <br><br>
        <input type="submit" value="Registra esta Jornada">
    </form>';
}

include "includes/footer.html";
?>