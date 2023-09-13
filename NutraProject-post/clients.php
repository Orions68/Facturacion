<?php
include "includes/conn.php";
$title = "Facturando - Nutra Project";
include "includes/header.php";
include "includes/modal.html";

if (isset($_POST["username"]))
{
	$name = $_POST["username"];
	echo "<script>let username='" . $name . "'</script>";
}
?>
<section class="container-fluid pt-3">
    <div class="row">
	<div id="pc"></div>
	<div id="mobile"></div>
        <div class="col-md-1" style="width: 2%;"></div>
            <div class="col-md-10">
                <div id="view1">
				<img alt="logo" src="img/logo.webp" height="300" width="100%"/>
					<br><br>
					<div style="font-size:x-large;">Factura a: <?php echo $name; ?></div>
					<br>
					<div class="row">
						<div class="col-md-6">
							<label><select id="brand" name="brand" onchange="getProduct(this.id)"> Selecciona los Productos por Marca</label>
								<option value=""> Elige la Marca</option>
							<?php
							$stmt = $conn->prepare('SELECT brand FROM products GROUP BY brand ORDER BY brand ASC'); // Obtiene todos los datos de los productos por marca, para ponerlos en el select.
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ))
							{
								echo  '<option value="' . $row->brand . '">' . $row->brand . '</option>'; // Se muestran las diferentes marcas.
							}
							?>
							</select> Selecciona por Marca</label><br><br>
						</div>
						<div class="col-md-6">
							<label><select id="kind" name="kind" onchange="getProduct(this.id)"> Selecciona los Productos por Grupo</label>
								<option value=""> Elige Tipo de Producto</option>
							<?php
							$stmt = $conn->prepare('SELECT kind FROM products GROUP BY kind ORDER BY kind ASC'); // Obtiene todos los datos de los productos por tipo, para ponerlos en el select.
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ))
							{
								echo  '<option value="' . $row->kind . '">' . $row->kind . '</option>'; // Se muestran los diferentes tipos de productos.
							}
							?>
							</select> Selecciona el Grupo</label>
						</div>
					</div>
					<br>
					<?php
					if (isset($_POST["article"])) // La página se recarga, se pierden todos los datos pero los vuelvo a enviar desde la función de javascript creando un formulario, verifico que se seleccionó.
					{
						$which = $_POST["which"]; // Which es lo que se seleccionó, marca/brand o tipo/kind.
						$name = $_POST["username"]; // Nombre del usuario al que se está facturando.
						$article = $_POST["article"]; // Es lo que se seleccionó, si which es marca/brand, NutraProject, Bio Life etc. si se seleccionó tipo/kind, Proteína, Vitaminas etc.
						if (isset($_POST["position"])) // Si está seleccionada una marca o tipo de producto se seleccionó del selector de Producto, función getStock().
						{
							$position = $_POST["position"]; // Asigno la posición seleccionada a la variable $position.
						}
						else // Si no está seteada la posición es porque los datos vienen de los selectores de tipo/kind y marca/brand.
						{
							$position = 0; // Pongo la variable $position en 0, es la primera posición del selector.
						}
						echo "<script>var which = '" . $which . "'; var article = '" . $article . "'; </script>"; // Asigno a las variables de javascript los valores de las mismas variables de php.
						if ($which == "kind") // Verifico si la selección fue tipo/kind.
						{
							$sql = "SELECT * FROM product WHERE kind='$article' ORDER BY product ASC"; // Busco en la base de datos por tipo/kind de producto.
						}
						else // Si no seleccioné marca/brand.
						{
							$sql = "SELECT * FROM product WHERE brand='$article' ORDER BY product ASC"; // Busco en la base de datos por marca/brand de producto.
						}
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						if ($stmt->rowCount() > 0) // Si hay resultados.
						{
							echo '<label><select id="product" name="product" onchange="getStock()">
								<option value="">Producto</option>'; // Pongo el selector de producto en la página con la primera opción en blanco value="".
							while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Mientras haya resultados.
							{
								if ($row->stock > 0) // Muestra todos los productos que tienen stock, si es stock es mayor que 0.
								{
									if ($row->stock >= 11) // Si es mayor que 11, normal.
									{
										echo  '<option value="' . $row->id . "," . $row->product . "," . $row->price . '">' . $row->product . " - " . number_format((float)$row->price, 2, ",", ".") . " €" . '</option>'; // Se muestra en una opción con color normal.
									}
									else if ($row->stock < 11 && $row->stock > 5) // Si está entre 11 y 6, Amarillo.
									{
										echo '<option style="color: yellow; background-color: darkgray;" value="' . $row->id . "," . $row->product . "," . $row->price . '">' . $row->product . " - " . number_format((float)$row->price, 2, ",", ".") . " €" . '</option>'; // Si está entre 6 y 10 se muestra en amarillo.
									}
									else // Si es 5 o menos, Rojo.
									{
										echo '<option style="color: red; background-color: lightgray;" value="' . $row->id . "," . $row->product . "," . $row->price . '">' . $row->product . " - " . number_format((float)$row->price, 2, ",", ".") . " €" . '</option>'; // Si hay 5 o menos se muestra en rojo.
									}
								}
							}
							echo '</select> Selecciona el Producto</label><br><br>'; // Cierro el selector de productos.
							echo "<script>let product = document.getElementById('product');
								product.selectedIndex = " . $position . ";</script>"; // Vuelvo a poner en el selector de productos la posición del producto seleccionado, esto es cuando selecciono un producto del selector de producto, si selecciono marca/brand o tipo/kind $position es 0.
						}
					}

					if (isset($_POST["id"])) // Este bloque de código se usa para mostrar el diálogo que hay pocos artículos de un determinado producto, después de seleccionarlo en el selector de productos.
					{
						$id = $_POST["id"]; // Obtengo la ID del producto seleccionado
						$sql = "SELECT product, stock FROM product WHERE id=$id"; // Busco el nombre del producto y la cantidad disponible/stock en la base de datos por la ID del producto.
						$stmt = $conn->prepare($sql); // Obtiene el stock del producto seleccionado.
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_OBJ);
						echo '<label><select id="qtty" name="qtty">'; // Muestro un selector de cantidad en la página y en las opciones cargo la cantidad máxima disponible del producto seleccionado.
						for ($i = 1; $i <= $row->stock; $i++) // Bucle desde 1 cantidad mínima a $row->stock que es el stock existente del producto seleccionado.
						{
							echo '<option value="' . $i . '">' . $i . '</option>'; // Lo pongo en las opciones.
						}
						echo '</select> Selecciona la Cantidad</label>'; // Cierro el select.
						if ($row->stock < 11 && $row->stock > 5) // Si hay entre 5 y 10 artículos.
						{
							echo "<script>toast(1, 'Stock Algo Bajo:', 'Hay " . $row->stock . " Unidades de " . $row->product . ".');</script>"; // Muestro el aviso en amarillo de stcok bajo.
						}
						else if ($row->stock <= 5) // Si hay 5 o menos.
						{
							if ($row->stock > 1) // Si hay más de 1
							{
								echo "<script>toast(2, 'Stock Muy Bajo:', 'Hay " . $row->stock . " Unidades de " . $row->product . ".');</script>"; // Muestro el aviso de stock muy bajo en rojo.
							}
							else // Si solo queda uno.
							{
								echo "<script>toast(2, 'Casi sin Stock:', 'Hay " . $row->stock . " Unidad de " . $row->product . ".');</script>"; // Muestro el aviso casi sin stock en rojo.
							}
						}
					}
					?>
						<br><br>
						<button onclick="add_article()" class="btn btn-info btn-lg">Agrega Producto</button>
						<br>
						<br>
						<form action="buyadmin.php" method="post">
                            <fieldset>
                            <legend>Selecciona la Forma de Pago</legend>
                            <label><input type="radio" name="way" value="Contado" checked> Contado</label>
                            <br>
                            <label><input type="radio" name="way" value="Tarjeta"> Tarjeta</label>
						<input type="hidden" name="invoice" id="invoice"> <!-- En este input con ID invoice voy poniendo los artículos que se van agregando para facturar.-->
						<input type="hidden" name="username" value="<?php echo $name; ?>">
                        </fieldset>
                        <br><br>
                        <?php
                        echo '<input id="factura" type="submit" value="Facturar!" style="width: 160px; height: 80px; visibility: hidden;" class="btn btn-primary">'; // Muestro el botón Facturar.
                        if (isset($_POST["invoice"])) // Si ya se agregó un artículo para facturar llega el dato invoice por post.
						{
							$valor = $_POST["invoice"]; // Obtengo los datos a facturar en la variable $valor.
							$valor2 = $_POST["productList"]; // Obtengo los datos que se muestran, la lista de la compra en la variable $valor2.
							echo '<script>let invoice = document.getElementById("invoice");
							let productList = document.getElementById("productList");
							valor = "' . $valor . '";
							valor2 = "' . $valor2 . '";
							invoice.value = "' . $valor . '";
							productList.innerHTML = "' . $valor2 . '";</script>'; // Asigno a las variables de javascript los valores de las mismas variables de php.
						}
                        ?>
						</form>
						<br><br><br>
                        <h2 id="productList"></h2> <!-- En este h2 con ID productlist pongo la lista de artículos agregados para facturar.-->
				</div>
            </div>
        <div class="col-md-1" style="width: 2%;"></div>
    </div>
    <br><br><br><br><br><br><br><br>
</section>
<?php
include "includes/footer.html";
?>