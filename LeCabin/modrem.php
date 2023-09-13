<?php
include "includes/conn.php";
$title = "Modificar/Eliminar Servicio";
include "includes/header.php";
?>
<img alt="logo" src="img/logo.jpg" height="300" width="100%"/>
<br>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br>
					<h1>Menú Para Modificar o Eliminar los Servicios.</h1>
					<?php
					$stmt = $conn->prepare('SELECT * FROM service');
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_OBJ))
					{
						echo '<br>';
						echo '<div style="border:4px solid blue;">';
						echo '<form action="update.php" method="post">';
						echo '<input type="hidden" name="id" value="' . $row->id . '">';
						echo '<label><input type="text" name="service" value="' . $row->service .'"> Servicio</label>';
						echo '<br><br>';
						echo '<label><input type="text" name="price" value="' . $row->price .'"> Precio</label>';
						echo '<br><br>';
						echo '<input type="submit" value="Modificar" style="width:160px; height:60px;" class="btn btn-success">';
						echo '</form>';
						echo '<form action="remove.php" method="post">';
						echo '<input type="hidden" name="id" value="' . $row->id . '">';
						echo '<input type="hidden" name="service" value="' . $row->service . '">';
						echo '<br><br>';
						echo '<input type="submit" value="Borrar Servicio." style="width:160px; height:60px;" class="btn btn-danger">';
						echo '</form>';
						echo '</div>';
					}
					?>
					<br><br>
					<input type="button" value="Cierra esta Ventana" onclick="window.close()">
				</div>
            </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>