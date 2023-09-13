<nav class="navbar fixed-top bg-white" id="mobile">
    <div class="col-md-10">
        <!-- Columnas con el menú de navegación. -->
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <select class="form-select" id="change" onchange="goThere()">
                <option value="">Selecciona Tu Opcion</option>
                <option value="view1">Inicio</option>
                <option value="view2">Nuestro Catálogo</option>
                <option value="view3">Perfil de Cliente</option>
                <option value="view4">Buscador de Productos</option>
                <option value="contact">Contacto</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" id="car_button" onclick="showCar(<?php echo count($_SESSION['car']); ?>)">Ver Contenido del Carro <img alt="Carro de la Compra" src="img/car.webp"></button>
    </div>
</nav>