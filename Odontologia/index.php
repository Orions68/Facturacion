<?php
include "includes/conn.php";
$title = "Página de Facturacion de la Clínica";
include "includes/header.php";
include "includes/modal.html";
include "includes/nav-index.html";
include "includes/nav-mob-index.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
                <h1>Facturación por Profesional y Paciante</h1>
                <br>
                <form action="invoice.php" method="post">
                    <?php
                    if (isset($_POST["patient"]))
                    {
                        $result = explode(",", $_POST["patient"]);
                        $id = $result[0];
                        $name = $result[1];
                        echo '<label><input id="patient" type="text" name="patient" value="' . $name . '" required> Nombre del Paciente</label>';
                    }
                    else
                    {
                        echo '<label><input type="text" name="patient" required> Nombre del Paciente <button class="btn btn-info" type="button" onclick="window.open(\'search.php?id=index\', \'_self\')">Pacientes con Cita Hoy</button>
                        <button class="btn btn-primary" type="button" onclick="window.open(\'showall.php?id=index\', \'_self\')">Todos los Pacientes</button></label>';
                    }
                    ?>
                <br><br>
                <label><select id="doc" name="doctor" style="visibility: hidden;" required>
                    <?php
                        if (isset($_POST["patient"]))
                        {
                        echo '<script>let doc_id = document.getElementById("doc");
                                doc_id.style.visibility = "visible";
                                </script>';
                        }
                        if (isset($_POST["doc"]))
                        {
                            $result = explode(",", $_POST["doc"]);
                            $id = $result[0];
                            $name = $result[1];
                            echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                        else
                        {
                            echo '<option value="">Selecciona el Profesional</oprtion>';
                        }
                        $sql = "SELECT id, name, speciality FROM doctor";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0)
                        {
                            while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                            {
                                echo '<option value="' . $row->id . '">' . $row->name . " - " . $row->speciality . '</option>';
                            }
                        }
                    ?>
                </select> Nombre del Profesional</label>
                <br><br>
                <?php
                if (isset($_POST["qtty"]))
                {
                    $qtty = $_POST["qtty"];
                    echo '<input type="hidden" id="qtty" name="qtty" value="' . $qtty . '">';
                    for ($i = 0; $i < $qtty; $i++)
                    {
                        if (isset($_POST["rep_name0"]) && $_POST["rep_name0"] != "Selecciona un Insumo")
                        {
                                $id = $_POST["rep_id" . $i];
                                $name = $_POST["rep_name" . $i];
                                $rep_qtty = $_POST["rep_qtty" . $i];
                                echo '<label><select id="rep' . $i . '" name="rep' . $i . '">
                                    <option value="' . $id . '">' . $name . '</option>
                                    </select> Selecciona el Insumo</label>
                                    <br><br>
                                    <label><select id="qtty_rep' . $i . '" name="qtty_rep' . $i . '">
                                    <option value="' . $rep_qtty . '">' . $rep_qtty . '</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    </select> Selecciona la Cantidad del Insumo</label><br><br>';
                        }
                        else
                        {
                            echo '<label><select id="rep' . $i . '" name="rep' . $i . '" required>
                            <option value="">Selecciona un Insumo</option>';
                            $sql = "SELECT id, name FROM replacement";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                }
                            }
                            echo '</select> Selecciona el Insumo</label>
                            <br><br>
                                <label><select id="qtty_rep' . $i . '" name="qtty_rep' . $i . '">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select> Selecciona la Cantidad del Insumo</label><br><br>';
                        }
                    }
                }
                else
                {
                ?>
                    <label><select id="qtty" name="qtty" onchange="prices()">
                    <option value="">Selecciona la cantidad de Insumos Empleados en el Tratamiento</option>
                        <option value="0">No Se Usaron</option>
                        <option value="1">Uno</option>
                        <option value="2">Dos</option>
                        <option value="3">Tres</option>
                        <option value="4">Cuatro</option>
                        <option value="5">Cinco</option>
                        <option value="6">Seis</option>
                        <option value="7">Siete</option>
                        <option value="8">Ocho</option>
                        <option value="9">Nueve</option>
                        <option value="10">Diez</option>
                    </select> Cantidad de Insumos</label>
                    <br><br>
                    <?php
                }
                if (isset($_POST["qtty2"]) && $_POST["qtty2"] > 0)
                {
                    $qtty = $_POST["qtty2"];
                    echo '<input type="hidden" id="qtty2" name="qtty2" value="' . $qtty . '">';
                    for ($i = 0; $i < $qtty; $i++)
                    {
                        if (isset($_POST["mat_name0"]))
                        {
                            $id = $_POST["mat_id" . $i];
                            $name = $_POST["mat_name" . $i];
                            $mat_qtty = $_POST["mat_qtty" . $i];
                            echo '<label><select id="mat' . $i . '" name="mat' . $i . '">
                                <option value="' . $id . '">' . $name . '</option>
                                </select> Selecciona los Desechables</label>
                                <br><br>
                                <label><select id="qtty_mat' . $i . '" name="qtty_mat' . $i . '">
                                <option value="' . $mat_qtty . '">' . $mat_qtty . '</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select> Selecciona la Cantidad de Desechables</label><br><br>';
                        }
                        else
                        {
                            echo '<label><select id="mat' . $i . '" name="mat' . $i . '" required>
                            <option value="">Selecciona un Desechable</option>';
                            $sql = "SELECT id, name FROM material";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                }
                            }
                            echo '</select> Selecciona los Desechables</label>
                            <br><br>
                                <label><select id="qtty_mat' . $i . '" name="qtty_mat' . $i . '">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                </select> Selecciona la Cantidad de Desechables</label><br><br>';
                        }
                    }
                }
                else
                {
                    if (isset($_POST["qtty2"]) && $_POST["qtty2"] == -1)
                    {
                ?>
                    <label><select id="qtty2" name="qtty2" onchange="prices()" style="visibility: hidden;">
                    <option value="">Selecciona la Cantidad de Desechables Empleados en el Tratamiento</option>
                        <option value="0">No Se Usaron</option>
                        <option value="1">Uno</option>
                        <option value="2">Dos</option>
                        <option value="3">Tres</option>
                        <option value="4">Cuatro</option>
                        <option value="5">Cinco</option>
                        <option value="6">Seis</option>
                        <option value="7">Siete</option>
                        <option value="8">Ocho</option>
                        <option value="9">Nueve</option>
                        <option value="10">Diez</option>
                    </select> Cantidad de Desechables</label>
                <?php
                    }
                }
                if (isset($_POST["qtty"]))
                {
                    echo '<input id="qtty2" type="hidden" name="qtty2" value="' . $_POST["qtty2"] . '">
                    <script>let qtty2_id = document.getElementById("qtty2");
                        qtty2_id.style.visibility = "visible";</script>';
                }
                ?>
                <br><br>
                    <label><input id="service" type="text" name="service" style="visibility: hidden;" required> Descripción del Tratamiento</label>
                    <br><br>
                    <label><input id="price" type="number" name="price" style="visibility: hidden;" step=".1" required> Precio a Cobrar</label>
                    <br><br>
                <input id="submit" class="btn btn-primary btn-lg" type="submit" style="visibility: hidden;" value="Factura al Paciente">
                </form>
                <br><br><br><br><br>
                <?php
                if (isset($_POST["qtty2"]) && $_POST["qtty2"] != -1)
                {
                    echo '<script>let service = document.getElementById("service");
                    let price = document.getElementById("price");
                    let submit = document.getElementById("submit");
                    service.style.visibility = "visible";
                    price.style.visibility = "visible";
                    submit.style.visibility = "visible";</script>';
                }
                ?>
            </div>
            <div id="view2">
                <br><br><br>
                <div class="row">
                    <div class="col-md-5">
                    <h2>Ver Relación de Facturas</h2>
                    <br>
                    <h4>Selecciona el Trimestre y el Año para Descargar un Informe de las Facturas del Trimestre que Necesites y Haz Click en Ver Informe.</h4>
                    <br>
                    <form action="export.php" method="post" target="_blank">
                        <label><select name="date">
                                <option value="1">1º Trimestre</option>
                                <option value="2">2º Trimestre</option>
                                <option value="3">3º Trimestre</option>
                                <option value="4">4º Trimestre</option>
                            </select> Selecciona el Trimestre a consultar</label>
                        <br><br>
                        <label><input type="number" id="year" name="year" min="2023" max="3000" step="1"> Selecciona el Año</label>
                        <br><br>
                        <input type="submit" value="Ver Informe" class="btn btn-info" style="height: 64px;">
                    </form>
                    <script>
                        var date = document.getElementById("year");
                        const d = new Date();
                        let year = d.getFullYear();
                        date.value = year;
                    </script>
                    <br><br>
                    <div>
                        <button onclick="window.open('showtotal.php', '_blank')" class="btn btn-primary" style="height: 64px;">Mostrar el Total de Ventas del Año</button>
                    </div>
                    <br><br>
                    <div>
                        <h3>Ver el Rendimiento por Profesional</h3>
                        <br>
                        <form action="result.php" method="post">
                        <label><select name="doc">
                            <option value="">Selecciona el Profesional</option>
                            <?php
                            $sql = "SELECT id, name FROM doctor";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    echo "<option value='" . $row->id . "'>" . $row->name . "</option>";
                                }
                            }
                            ?>
                        </select> Selecciona el Profesional</label>
                        <br><br>
                        <label><select name="month">
                            <option value="">Selecciona el Mes</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select> Selecciona el Mes</label>
                        <br><br>
                        <input type="submit" value="Ver el Rendimiento">
                        </form>
                    </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                    <h2>Ver Facturas por Día de Facturación</h2>
                    <br><br>
                    <h4>Selecciona la Fecha a Consultar</h4>
                    <br><br>
                    <form action="showinvoices.php" method="post" target="_blank">
                        <label><input type="date" name="date"></label>
                            <br><br>
                            <input type="submit" value="Busca esa fecha" class="btn btn-info btn-lg">
                    </form>
                    <br><br>
                    <h4>Ver la Última Factura Ingresada</h4>
                    <br><br>
                    <form action="lastinvoice.php" method="post" target="_blank">
                            <input type="submit" value="Muestrame la Última Factura" class="btn btn-success btn-lg">
                    </form>
                    <br><br>
                    <div>
                        <button onclick="window.open('db-backup.php', '_blank')" class="btn btn-secondary" style="height: 64px;">Copia de Respaldo de la Base de Datos</button>
                    </div>
                </div>
                </div>
            </div>
            <div id="view3">
                <br><br><br>
                <h1>Citas de los Pacientes</h1>
                <br>
                <div class="row">
                    <div class="col-md-4 border">
                    <h3>Asigna la Proxima Citas a Personas Atendidas Hoy</h3>
                    <br>
                    <button onclick="window.open('dates.php', '_self')"> Selecciona el Paciente</button>
                    </div>
                    <div class="col-md-4 border">
                        <h3>Asigna una Cita a un Paciente Dado de Alta en el Sistema</h3>
                        <br>
                        <form action="getpatient.php" method="post">
                            <label><input type="text" name="dni"> Busca por el D.N.I. de la Persona</label>
                            <br><br>
                            <input type="submit" value="Busca este DNI">
                        </form>
                    </div>
                    <div class="col-md-4 border">
                        <h3>Dar de Alta en el Sistema una Nueva Persona</h3>
                        <br>
                        <form action="signup.php" method="post" onsubmit="return verify()">
                            <label><input type="text" name="patient" required> Nombre</label>
                            <br><br>
                            <label><input type="text" name="surname" required> Primer Apellido</label>
                            <br><br>
                            <label><input type="text" name="surname2"> Segundo Apellido</label>
                            <br><br>
                            <label><input id="dni" type="text" name="dni" required> D.N.I. o N.I.E.</label>
                            <br><br>
                            <label><input type="text" name="phone" required> Teléfono</label>
                            <br><br>
                            <input type="submit" value="Agrego esta Persona">
                            <br><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>