<?php
include "includes/conn.php";
$title = "Citas a los Pacientes";
include "includes/header.php";
?>
<section class="container-fluid pt-3">
    <div id="pc"></div>
    <div id="mobile"></div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br>
                <h1>Cita al paciente</h1>
                <br>
                <form action="reserve.php" method="post">
                <?php
                    if (isset($_POST["patient"]))
                    {
                        $result = explode(",", $_POST["patient"]);
                        $id = $result[0];
                        $name = $result[1];
                        echo '<label><input type="text" name="patient" value="' . $name . '"> Nombre del Paciente </label>';
                    }
                    else
                    {
                        $name = "";
                        echo '<label><input type="text" name="patient"> Nombre del Paciente <button class="btn btn-info" type="button" onclick="window.open(\'search.php?id=dates\', \'_self\')">Pacientes con Cita Hoy</button></label>
                        <button class="btn btn-primary" type="button" onclick="window.open(\'showall.php?id=dates\', \'_self\')">Todos los Pacientes</button>';
                    }
                ?>
                <h2 class="highlight" id="docname"></h2>
                <br><br>
                <label id="doc_label"><select id="doc" name="doc">
                    <option value="">Selecciona un Profesional</option>
                    <?php
                    $sql = "SELECT id, name FROM doctor";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    while($row = $stmt->fetch(PDO::FETCH_OBJ))
                    {
                        echo '<option value="' . $row->id . "," . $row->name . '">' . $row->name . '</option>'; // Este select muestra los nombres de los médicos de la base de datos.
                    }
                    ?>
                </select> Selecciona el Nombre del Profesional
                <br></label><br><br>
                <?php
                if ($name != "")
                {
                    echo "<script>let user = '" . $name . "';
                    let user_id = '" . $id . "'</script>
                    <label id='date_label'><input id='date' type='date' name='date' onchange='sendDate(user_id, user)'>Selecciona la Fecha Para ver las Citas Disponibles
                <br><br></label>";
                }
                else
                {
                    echo "<label id='date_label'><input id='date' type='date' name='date' onchange='sendDate(\"\", \"\")'>Selecciona la Fecha Para ver las Citas Disponibles
                    <br><br></label>";
                }

                if (isset($_POST["date"])) // Al seleccionar la fecha en el input type date se recarga el script pasandole la fecha y otros datos por post.
                {
                    $result = explode("," , $_POST["patient"]);
                    $id = $result[0];
                    $name = $result[1];
                    $doc_id = $_POST["doc_id"]; // Recibe la ID del médico, se separa en la función sendDate() de javascript.
                    $doc = $_POST["doc"]; // Recibe el nombre del médico, se separa en la función sendDate() de javascript.
                    $date = $_POST["date"]; // Recibe la fecha seleccionada.
                    $latin = explode("-", $date); // Explota la fecha en la variable $latin, para mostrar la fecha en formato latino.
                    echo '<script>let date_label = document.getElementById("date_label");
                    let doc_label = document.getElementById("doc_label");
                    date_label.style.display = "none";
                    doc_label.style.display = "none";
                    let docname = document.getElementById("docname");
                    docname.innerHTML = "Cita con: ' . $doc . ' el día: ' . $latin[2] . "/" . $latin[1] . "/" . $latin[0] . '";</script>
                    <label><select name="time" required>
                    <option value="">Selecciona una Hora para La Cita</option>'; // Script se javascript, recoge las ID de date_label, de doc_label y los quita de la pantalla, y docname, que es donde muestra El profesional y la fecha de la cita.
                    $i = 8; // Hora de comienzo de atención.
                    $sql = "SELECT time FROM date WHERE date='$date' AND doc_id='$doc_id' ORDER BY time ASC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(); // Busco en la base de datos las citas que tiene el profesional por su ID en el día seleccionado, ordenadas de menor a mayor.
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Mientras haya resultados.
                    {
                        for ($i = $i; $i < 20; $i++) // Hago un bucle desde las 8 de la mañana hasta las 19 Hs.
                        {
                            if ($i < 10) // Si $i es menor que 10.
                            {
                                $i = "0" . $i; // Le agrego un cero delante.
                            }
                            if ($row->time != ($i . ":00:00")) // Si la hora de la cita en la columna de la base de datos es distinta al valor de $i más :00:00.
                            {
                                echo '<option value="' . $i . ":00:00" . '">' . $i . ":00:00" . '</option>'; // La pongo como opción para seleccionar.
                            }
                            else // Si ya está cogida esa cita.
                            {
                                $i++; // Incremento $i, ya que esa hora está dada.
                                break; // Rompo el bucle for y espero el siguiente resultado de la base de datos.
                            }
                        }
                    }
                    for ($i = $i; $i < 20; $i++) // Cuando no hay más resultados en la base de datos, hago un bucle desde el valor con el que terminó $i hasta las 20 Hs.
                    {
                        if ($i < 10) // Si $i es menor que 10.
                        {
                            $i = "0" . $i; // Le agrego un cero delante.
                        }
                        echo '<option value="' . $i . ":00:00" . '">' . $i . ":00:00" . '</option>'; // Pongo como opción todos los valores que no están en la base de datos.
                    }
                    echo '</select> Selecciona la Hora de la Cita</label>
                    <br><br>
                        <input type="hidden" name="id" value="' . $id . '">
                        <input type="hidden" name="doctor_id" value="' . $doc_id . '">
                        <input type="hidden" name="doctor" value="' . $doc . '">
                        <input type="hidden" name="date" value="' . $date . '">
                        <br><br>
                        <input type="submit" value="Reserva Esta Cita" class="btn btn-primary">
                        </form>'; // Cierro el select del paciente, agrego los input hidden, doctor_id y date, muestro el botón para enviar el formulario y cierro el formulario.
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