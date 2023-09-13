<?php
include "includes/conn.php";
$title = "Total Facturado Hasta Ahora en el Año";
include "includes/header.php";
$final = 0;
?>
<img alt="logo" src="img/logo.jpg" height="300" width="100%"/>
<br>
<section class="container-fluid pt-3">
    <div class="row">
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
						echo "<h2>La Facturación de todo el año hasta ahora es : " . $final . " €.</h2>";
					}
					?>
					<br>
					<br>
					<input type="button" value="Cierra Esta Ventana" onclick="window.close()">
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>