<?php
include "includes/conn.php";
$title = "Buscando Productos";
include "includes/header.php";
include "includes/modal-dismiss.html";
include "includes/nav-start.html";
include "includes/nav-mob-start.html";
$selected = 0;

if (isset($_REQUEST["kind"])) // Verifico si llega tipo(kind).
{
    $kind = $_REQUEST["kind"]; // La variable $kind contiene lo que seleccionó el cliente, Proteínas, Vitamínas, Carbohidratos, etc.
    $selected = 1; // La variable $selected a 1, se seleccionó por tipo.
    if (empty($_SESSION["type"])) // Si la sesión type está vacía.
    {
        $_SESSION["type"] = []; // La sesión type es un array.
        $_SESSION["type"][0] = "kind"; // En la primera posición del array pongo que la selección es por tipo.
        $_SESSION["type"][1] = $kind; // En la segunda posición del array pongo que tipo se seleccionó
    }
    else // Si la sesión ya está iniciada.
    {
        $_SESSION["type"][0] = "kind"; // En la primera posición del array pongo que la selección es por tipo.
        $_SESSION["type"][1] = $kind; // En la segunda posición del array pongo que tipo se seleccionó
    }
}
else if (isset($_REQUEST["brand"])) // Si se seleccionó por marca(brand).
{
    $brand = $_REQUEST["brand"]; // La variable $brand contiene la marca seleccionada.
    $selected = -1; // La varuiable $selected a -1, se seleccionó por marca.
    if (empty($_SESSION["type"])) // Si la sesión type está vacía.
    {
        $_SESSION["type"] = []; // La sesión type es un array.
        $_SESSION["type"][0] = "brand"; // En la primera posición del array pongo que la selección es por marca.
        $_SESSION["type"][1] = $brand; // En la segunda posición del array pongo que marca se seleccionó
    }
    else
    {
        $_SESSION["type"][0] = "brand"; // En la primera posición del array pongo que la selección es por marca.
        $_SESSION["type"][1] = $brand; // En la segunda posición del array pongo que marca se seleccionó
    }
}
include "catalog.php"; // Incluyo el script catalog.php que muestra en pantalla los artículos según se haya seleccionado por tipo o por marca.

?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="view1">
                <br>
                <?php
                if ($selected == 1)
                {
                    echo "<h1>$kind</h1>";
                }
                else
                {
                    echo "<h1>$brand</h1>";
                }
                ?>
                <br>
                <h3>Tenemos Estos Productos a la Venta.</h3>
                <br>
                <?php
                switch ($selected) // Según la selección
                {
                    case 1:
                        fromSearch($conn, $kind, $selected); // Llamo a la función mostrar los productos por tipo, le paso la conexión, el tipo seleccionado y lo que seleccioné.
                        break;
                    case -1:
                        fromSearch($conn, $brand, $selected); // Llamo a la función mostrar los productos por marca, le paso la conexión, la marca y lo que seleccioné.
                        break;
                    default:
                        echo "<script>toast(2, 'Error Grave', 'Has Llegado Aquí Por Error.');</script>";
                        break;
                }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<?php
include "includes/footer.html";
?>