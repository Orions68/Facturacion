<?php
include "includes/conn.php";
$title = "Total Facturado Hasta Ahora en el Año";
include "includes/header.php";
$final = 0;
?>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
					<?php
					$stmt = $conn->prepare('SELECT total FROM invoice');
					$stmt->execute();
					if ($stmt->rowCount() > 0)
					{
						while($row = $stmt->fetch(PDO::FETCH_OBJ))
						{
							$final += $row->total;
						}
					}
					else
					{
						echo "<h3>Sin Datos Aun.</h3>";	
					}
					if ($final != 0)
					{
						echo "<h2>La Facturación de todo el año hasta ahora es : " . number_format((float)$final, 2, ',', '.') . " €.</h2>";
					}
					else
					{
						echo "<h2>No se ha Facturado nada en todo el año hasta ahora.</h2>";
					}
					?>
					<br>
					<br>
					<button class="btn btn-danger" onclick="window.close()">Cierra Esta Ventana</button>
					<br>
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>