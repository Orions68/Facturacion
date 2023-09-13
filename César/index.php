<?php
$title = "Pagina Principal de César Matelat";
include "inc/header.php";
include "inc/nav-index.html";
include "inc/nav-mob-index.html";
if (isset($_SESSION["input"]))
{
    session_unset();
}
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1" style="margin-bottom: 50%;">
                    <br><br><br><br>
                    <h1>Facturación de Servicios Informáticos</h1>
                    <br><br>
                    <form id="form" action="invoice.php" method="post" target="_self">
                        <label><input type="text" name="client"> Datos del Cliente, Si lo Dejas en Blanco se Facturará a Consumidor Final</label>
                        <br><br>
                        <label><input type="text" name="job" required> Breve Descripción del Trabajo</label>
                        <br><br>
                        <label><input type="number" name="price" step=".5" required> Mano de Obra</label>
                        <br><br>
                        <label><input type="date" name="date" required> Fecha del Servicio</label>
                        <br><br>
                        <label><select name="hour" required>
                            <option value="">Selecciona la Hora</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="18">17</option>
                            <option value="18">18</option>
                        </select> Hora del Servicio</label>
                        <br><br>
                        <label><select name="minutes" required>
                            <option value="">Selecciona los Minutos</option>
                            <option value="0">0</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select> Hora del Servicio</label>
                        <br><br>
                        <input type="submit" value="Agrego esta Factura">
                    </form>
                </div>
                <div id="view2">
                    <br><br><br>
                    <div class="row">
						<div class="col-md-5">
                        <h1>Acá Vas a Ver Las Facturas Para Sacar la Relación del Trimestre</h1>
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
							<button onclick="window.open('showtotal.php', '_blank')" class="btn btn-primary" style="height: 64px;">Mostrar el Total de Ventas del Año</button>
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
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "inc/footer.html";
?>