<?php
include "includes/conn.php";
$title = "La Peluquería de Javier Borneo - Página Principal";
include "includes/header.php";
include "includes/modal.html";
include "includes/modal-img.html";
if (isset($_SESSION["client"]))
{
    include "includes/nav_client.php";
    include "includes/nav-mob-client.php";
}
else
{
    include "includes/nav_index.html";
    include "includes/nav-mob-index.html";
}
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br><br><br>
					<header>      
                    <!-- Jumbotron -->
                    <!-- Background image -->
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                        <div class="d-flex justify-content-center align-items-center h-100"></div>
                            <div class="text-white">
                                    <h1 class="mb-3">La Peluquería de Javier Borneo</h1>
                            </div>
                    </div>
                    <div id="slide" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="img/corte.jpg" class="d-block w-100" alt="Corte" width="960px" height="600px">
                            </div>
                            <div class="carousel-item">
                                <img src="img/reflex.jpg" class="d-block w-100" alt="Reflejos" width="960px" height="600px">
                            </div>
                            <div class="carousel-item">
                                <img src="img/fix.jpg" class="d-block w-100" alt="Arreglo de Barba" width="960px" height="600px">
                            </div>
                            <div class="carousel-item">
                                <img src="img/brush.jpg" class="d-block w-100" alt="Peinado" width="960px" height="600px">
                            </div>
                            <div class="carousel-item">
                                <img src="img/shave.jpg" class="d-block w-100" alt="Afeitado" width="960px" height="600px">
                            </div>
                            <div class="carousel-item">
                                <img src="img/dye.jpg" class="d-block w-100" alt="Color" width="960px" height="600px">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#slide" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#slide" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <div class="mask" style="background-color: rgba(0, 255, 0, 0.6);">
                        <div class="d-flex justify-content-center align-items-center h-100"></div>
                            <div class="text-white">
                                <h2 class="mb-3">Atención a Domicilio</h2>
                            </div>
                    </div>
                    <!-- Jumbotron -->
                    </header>
                    <h3>Todos los Servicios de Peluquería al Mejor Precio.</h3>
                    <br>
                </div>
                <div id="view2">
                    <div class="col-md-7">
                        <br><br><br><br>
                        <h2>Nuestros Precios son los Mejores de la Ciudad</h2>
                        <br>
                        <h3>Lista de Precios:</h3>
                        <br>
                        <?php
                            $i = 0;
                            $ok = false;
                            $sql = "SELECT service, price, img FROM service";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0)
                            {
                                $ok = true;
                                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                                {
                                    $service[$i] = $row->service;
                                    $price[$i] = $row->price;
                                    $img[$i] = $row->img;
                                    $i++;
                                }
                            }
                            else
                            {
                                echo "<script>toast(1, 'No hay nada aun:', 'Estamos Trabajando en la Tienda Online, Pronto Verás la Lista de Precios.')</script>";
                            }
                            if ($ok)
                            {
                                echo "<script>var service = [];</script>";
                                echo "<script>var price = [];</script>";
                                echo "<script>var img = [];</script>";
                                for ($i = 0; $i < count($service); $i++)
                                {
                                    echo "<script>service[" . $i . "] = '" . $service[$i] . "';</script>";
                                    echo "<script>price[" . $i . "] = '" . $price[$i] . "';</script>";
                                    echo "<script>img[" . $i . "] = '" . $img[$i] . "';</script>";
                                }
                            }
                        ?>
                        <div id="table"></div>
                        <br>
                        <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button onclick="prev('index')" id="prev" class="btn btn-danger" style="visibility: hidden;">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button onclick="next('index')" id="next" class="btn btn-primary" style="visibility: hidden;">Siguientes Resultados</button><br>
                        <script>change(1, 5, "index");</script>
                        <br>
                        <h4>Puedes Registrarte y Solicitar tu Turno Online.</h4>
                    </div>
                </div>
                <div id="view3">
                    <div class="row">
                        <div class="col-md-7">
                        <br><br><br>
                            <h2>Te Damos la Bienvenida a la WEB de la Peluquería de Javier Borneo</h2>
                            <br>
                            <h3>Registro de Clientes</h3>
                            <br>
                            <form action="register.php" method="post" onsubmit="return verify()">
                                <label><input type="text" name="username" required> Nombre</label>
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
                                <label><input type="password" name="pass" id="pass1" onkeypress="showEye(1)" required> Contraseña</label>
                                <i onclick="spy(1)" class="far fa-eye" id="togglePassword1" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                                <br><br>
                                <label><input type="password" id="pass2" onkeypress="showEye(2)" required> Repite Contraseña</label>
                                <i onclick="spy(2)" class="far fa-eye" id="togglePassword2" style="margin-left: -205px; cursor: pointer; visibility: hidden;"></i>
                                <br><br>
                                <label><input type="date" name="bday" required> Cumpleaños</label>
                                <br><br>
                                <input type="submit" value="Regístrame!">
                            </form>
                        </div>
                        <div class="col-md-5">
                            <br><br><br><br><br><br><br>
                            <h3>Entrada de Clientes para Solicitar un Turno</h3>
                            <br>
                            <form action="profile.php" method="post">
                                <label><input type="email" name="email" required> E-mail</label>
                                <br><br>
                                <label><input type="password" name="pass" id="pass3" onkeypress="showEye(3)" required> Contraseña</label>
                                <i onclick="spy(3)" class="far fa-eye" id="togglePassword3" style="margin-left: -140px; cursor: pointer; visibility: hidden;"></i>
                                <br><br>
                                <input type="submit" value="Login">
                            </form>
                            <a href="recover.php"><small>Olvidaste tu Contraseña</small></a>
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