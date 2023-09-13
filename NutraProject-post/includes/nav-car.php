<nav class="navbar fixed-top bg-white" id="pc">
    <div class="col-md-10">
        <!-- Columnas con el menú de navegación. -->
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link" aria-current="page" href="index.php#view1" aria-selected="false" role="tab" aria-controls="nav-contact">Inicio</a>
            <a class="nav-link" aria-current="page" href="index.php#view2" aria-selected="false" role="tab" aria-controls="nav-contact">Nuestro Catálogo</a>
            <a class="nav-link" aria-current="page" href="#view3" aria-selected="false" role="tab" aria-controls="nav-contact">Perfil de Cliente</a>
            <a class="nav-link" aria-current="page" href="index.php#view4" aria-selected="false" role="tab" aria-controls="nav-contact">Buscador de Productos</a>
            <a class="nav-link" aria-current="page" href="contact.php" target="_blank" aria-selected="false" role="tab" aria-controls="nav-contact">Contacto</a>
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" id="car_button" onclick="showCar(<?php echo count($_SESSION['car']); ?>)">Ver Contenido del Carro <img alt="Carro de la Compra" src="img/car.webp"></button>
    </div>
</nav>