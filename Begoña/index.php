<?php
include "includes/conn.php";
$title = "Administración de Grupo Tagor";
include "includes/header.php";
include "includes/nav-pc.html";
include "includes/nav-mob.html";
if (isset($_SESSION["input"]))
{
    session_unset();
}
?>
<section class='container-fluid pt-3'>
    <div class='row'>
        <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div id='view1' class="p-3">
                    <br><br><br><br>
                    <h1>Facturar a:</h1>
                    <br>
                    <form action='invoice.php' method='post'>
                        <label><select name='patient' required>
                        <option value=''>Selecciona un Nombre</option>
                    <?php
                    $sql = "SELECT id, name FROM patients";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                    {
                        echo "<option value='" . $row->id . "," . $row->name . "'>" . $row->name . "</option>";
                    }
                    ?>
                    </select> Selecciona Paciente</label>
                    <br><br>
                    <label><input type="text" name="desc" required> Concepto</label>
                    <br><br>
                    <label><select name="qtty">
                        <option value="1">1 Sesión</option>
                        <option value="2">2 Sesiónes</option>
                        <option value="3">3 Sesiónes</option>
                        <option value="4">4 Sesiónes</option>
                        <option value="5">5 Sesiónes</option>
                    </select> Cantidad</label>
                    <br><br>
                    <label><input type="number" name="price" required> Precio por Sesión en Euros</label>
                    <br><br>
                    <input type="submit" class="btn btn-primary btn-lg" value="Genero la Factura">
                    </form>
                </div>
                <div id="view2" class="p-3">
                <br><br><br><br>
                <h1>Agrega los Datos de las Personas para Facturar</h1>
                <br><br>
                <form action="addpatient.php" method="post" target="_self">
                    <label><input type="text" name="client" required> Nombre Completo</label>
                    <br><br>
                    <label><input type="text" name="phone"> Teléfono</label>
                    <br><br>
                    <label><input type="text" name="email"> E-mail</label>
                    <br><br>
                    <input type="submit" class="btn btn-primary btn-lg" value="Agrego a la Base de Datos">
                </form>
                </div>
                <div id="view3" class="p-3">
                    <br><br><br><br>
                    <div class="row">
						<div class="col-md-5">
                        <h1>Aquí Puedes Obtener la Relación Facturas por Trimestre</h1>
                        <br>
                        <br>
                        <h4>Selecciona el Trimestre y el Año para Descargar un Informe de las Facturas del Trimestre que Necesites y Haz Click en Ver Informe.</h4>
                        <br>
                        <form action="export.php" method="post" target="_blank">
                            <label>
                                <select name="date">
                                    <option value="1">1º Trimestre</option>
                                    <option value="2">2º Trimestre</option>
                                    <option value="3">3º Trimestre</option>
                                    <option value="4">4º Trimestre</option>
                                </select> Selecciona el Trimestre a consultar
                            </label>
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
							<button onclick="window.open('showtotal.php', '_blank')" class="btn btn-primary" style="height: 64px;">Mostrar el Total de Facturación del Año</button>
						</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-6">
                            <br>
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
                            <br>
                            <form action="lastinvoice.php" method="post" target="_blank">
									<input type="submit" value="Muestrame la Última Factura" class="btn btn-success btn-lg">
							</form>
                            <br><br><br>
							<div>
								<button onclick="window.open('db-backup.php', '_blank')" class="btn btn-secondary" style="height: 64px;">Copia de Respaldo de la Base de Datos</button>
							</div>
                        </div>
				    </div>
                </div>
                <div id="view4" class="p-3">
                    <br><br><br><br>
                    <h1>Esta es la Lista de las Personas en tu Base de Datos</h1>
                    <br><br>
                    <?php
                        $sql = "SELECT * FROM patients;";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0)
                        {
                            $ok = true;
                            $i = 0;
                            $id = [];
                            $patient = [];
                            $phone = [];
                            $email = [];

                            while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                            {
                                $id[$i] = $row->id;
                                $patient[$i] = $row->name;
                                $phone[$i] = $row->phone;
                                $email[$i] = $row->email;
                                $i++;
                            }
                        }
                        else
                        {
                            $ok = false;
                            echo "<script>toast(1, 'Aun sin Datos', 'No hay Pacientes en tu Base de Datos.');</script>"; // Error, has llegado por el camino equivocado.
                        }
                        if ($ok)
                        {
                            echo "<script>var id = [];</script>";
                            echo "<script>var patient = [];</script>";
                            echo "<script>var phone = [];</script>";
                            echo "<script>var email = [];</script>";
                            for ($i = 0; $i < count($patient); $i++)
                            {
                                echo "<script>id[" . $i . "] = '" . $id[$i] . "';</script>";
                                echo "<script>patient[" . $i . "] = '" . $patient[$i] . "';</script>";
                                echo "<script>phone[" . $i . "] = '" . $phone[$i] . "';</script>";
                                echo "<script>email[" . $i . "] = '" . $email[$i] . "';</script>";
                            }
                        }
                    ?>
                    <div id="table"></div>
                    <br>
                    <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button onclick="prev()" id="prev" class="btn btn-success">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button onclick="next()" id="next" class="btn btn-danger">Siguientes Resultados</button><br>
                    <script>change(1, 13);</script>
                </div>
            </div>
        <div class='col-sm-1'></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>