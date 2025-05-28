<?php
include "includes/conn.php";
$title = "Nutra Project - Bienvenidos";
include "includes/header.php";
if (!empty($_SESSION["client"]))
{
    include "includes/nav-profile.php";
    include "includes/nav-mob-profile.php";    
}
else
{
    include "includes/nav-index.html";
    include "includes/nav-mob-index.html";
}
include "includes/modal.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br><br><br><br><br>
                <header>
                    <!-- Jumbotron -->
                    <!-- Background image -->
                    <div class="col-md-9">
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                        <div class="d-flex justify-content-center align-items-center h-100"></div>
                            <div class="text-white">
                                    <h1 class="mb-3">Nutra Project</h1>
                            </div>
                    </div>
                    <div class="p-5 text-center bg-image" style="background-image: url('img/logo.webp'); background-repeat: no-repeat; height: 480px;">
                    </div>
                    <div class="mask" style="background-color: rgba(0, 255, 0, 0.6);">
                        <div class="d-flex justify-content-center align-items-center h-100"></div>
                            <div class="text-white">
                                <h1 class="mb-3">Eres tu Propio Proyecto, te Proporcionamos los Ingredientes</h1>
                            </div>
                    </div>
                    <!-- Jumbotron -->
                    </div>
                </header>
                <h1>La Tienda de Nutrición con Todo lo que Necesitas</h1>
                <br>
            </div>
            <?php
            if (empty($_SESSION["client"]))
            {
                ?>
            <div id="view2">
                <br><br><br>
                <h1>Nuestro productos destacados</h1>
                <br>
                <h3>Para Ver Todos los Productos Usa "Buscador de Productos" en el Menú</h3>
                <?php
                include "catalog.php";
                fromIndex($conn);
                ?>
            </div>
            <div id="view3">
                <div class="row">
                    <div class="col-md-7">
                    <br><br><br><br><br>
                        <h3>Registro de Cliente</h3>
                        <br>
                        <form action="register.php" method="post" target="_blank" onsubmit="return verify()">
                            <label><input type="text" name="username" required> Tu Nombre</label>
                            <br><br>
                            <label><input type="text" name="surname" required> Apellido 1</label>
                            <br><br>
                            <label><input type="text" name="surname2"> Apellido 2</label>
                            <br><br>
                            <label><input type="text" name="address" required> Dirección</label>
                            <br><br>
                            <label><input type="text" name="phone" required> Teléfono</label>
                            <br><br>
                            <label><input type="email" name="email" required> E-mail</label>
                            <br><br>
                            <label><input type="password" name="pass" id="pass0" onkeypress="showEye(0)" required> Contraseña</label>
                            <i onclick="spy(0)" class="far fa-eye" id="togglePassword0" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                            <br><br>
                            <label><input type="password" id="pass1" onkeypress="showEye(1)" required> Repite Contraseña</label>
                            <i onclick="spy(1)" class="far fa-eye" id="togglePassword1" style="margin-left: -205px; cursor: pointer; visibility: hidden;"></i>
                            <br><br>
                            <label><input type="date" name="bday" required> Fecha de Nacimiento</label>
                            <br><br>
                            <input type="submit" value="Regístrame!">
                        </form>
                    </div>
                    <div class="col-md-5">
                        <br><br><br><br><br>
                        <h3>Entrada de Cliente</h3>
                        <br>
                        <form action="profile.php" method="post">
                            <label><input type="email" name="email" required> E-mail</label>
                            <br><br>
                            <label><input type="password" name="pass" id="pass2" onkeypress="showEye(2)" required> Contraseña</label>
                            <i onclick="spy(2)" class="far fa-eye" id="togglePassword2" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                            <br><br>
                            <input type="submit" value="Login">
                        </form>
                        <br>
                        <a href="recover.php"><small>Olvidaste tu Contraseña</small></a>
                    </div>
                    </div>
                </div>
            </div>
            <?php
            echo '<div id="view4">';
            }
            else
            {
                echo '<div id="view2">';
            }
            ?>
                <br><br><br><br><br>
                <div class="row">
                    <div class="col-md-6">
                    <h2>Busca lo que Necesitas</h2>
                    <br><br><br>
                    <form action="search.php" method="post" id="form">
                    <label><select id="kind" name="kind" onchange="document.getElementById('form').submit(); document.getElementById('form').reset();"> Selecciona los Productos por Grupo</label>
								<option value="" disabled selected> Elige Tipo de Producto</option>
							<?php
							$stmt = $conn->prepare('SELECT kind FROM product GROUP BY kind ORDER BY kind ASC'); // Obtiene todos los datos de los productos por tipo, para ponerlos en el select.
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ))
							{
								echo  '<option value="' . htmlspecialchars($row->kind, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->kind, ENT_QUOTES, 'UTF-8') . '</option>'; // Se muestran los diferentes tipos de productos.
							}
							?>
							</select> Selecciona el Grupo</label>
                    </form>
                    </div>
                    <div class="col-md-6">
                        <br><br><br><br><br>
                    <form action="search.php" method="post" id="form1">
                    <label><select id="brand" name="brand" onchange="document.getElementById('form1').submit(); document.getElementById('form1').reset();"> Selecciona los Productos por Marca</label>
								<option value="" disabled selected> Elige la Marca</option>
							<?php
							$stmt = $conn->prepare('SELECT brand FROM product GROUP BY brand ORDER BY brand ASC'); // Obtiene todos los datos de los productos por marca, para ponerlos en el select.
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_OBJ))
							{
								echo  '<option value="' . htmlspecialchars($row->brand, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row->brand, ENT_QUOTES, 'UTF-8') . '</option>'; // Se muestran las diferentes marcas.
							}
							?>
							</select> Selecciona por Marca</label><br><br>
                    </form>
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