<?php
include "includes/conn.php";
$title = "Nutra Project - Descripción de Productos";
include "includes/header.php";
include "includes/car-dialog.html";
include "includes/modal.html";

if (empty($_SESSION["car"])) // Si la variable de sesión está vacía.
{
    $_SESSION["car"] = []; // Inicializo la variable de sesión que contendrá la compra, el carro de la compra.
}
include "includes/car.html"; // Incluyo el script del carro de la compra.

if (isset($_POST["product"])) // Recibe el producto agregado y la cantidad más el precio del producto.
{
    $ok = true;
    $id = $_POST["id"];
    $qtty = $_POST["qtty"];
    $stock = $_POST["stock"];
    $product = $_POST["product"]; // Recibo los ID, producto, precio, stock y cantidad.
    $price = $_POST["price"];
    for ($i = 0; $i < count($_SESSION["car"]); $i+=5) // $i se Incrementa en 5 es la cantidad de datos en el array de sesión car.
    {
        if ($_SESSION["car"][$i] == $id) // Si en el array de sesión car en la posición 0, 5, 10, 15, etc. está la misma id que ya está en el carro, producto repetido.
        {
            $ok = false; // Pongo el booleano $ok a false.
            echo "<script>toast(1, 'Ya Tienes: " . $product . " en el Carro de la Compra', 'Puedes Quitar un Producto o Agregar Unidades Dentro del Carro.');</script>"; // Muestro el diálogo  que avisa que el artículo ya ha sido agregado al carro.
        }
    }
    if ($ok) // Si sale con $ok a true.
    {
        $sql = "UPDATE product SET stock=stock - $qtty WHERE id=$id"; // Hago un Update del stock del producto agregado al carro, resta.
        $stmt = $conn->prepare($sql); // Preparo la Consulta.
        $stmt->execute(); // La ejecuto.
        array_push($_SESSION["car"], $id);
        array_push($_SESSION["car"], $qtty); // Lo agrego al array de sesión car.
        array_push($_SESSION["car"], $stock);
        array_push($_SESSION["car"], $product);
        array_push($_SESSION["car"], $price);
        echo "<script>carToast('" .  $product . "','" . $price . "','" . $qtty . "');</script>"; // Muestro el diálogo temporal que muestra lo que se ha agregado al carro.
    }

    clean(); // Llamo a la función clean que pone en los array de javascript los valores de cada producto agregado al carro.
}

function clean() // Llena las varaibles de javascript.
{
    echo "<script>
    var ids = [];
    var qtty = [];
    var stock = [];
    var product = [];
    var price = [];
    </script>";
    $size = count($_SESSION["car"]); // Obtengo el tamaño del array, el carro de la compra.
    for ($i = 0; $i < $size; $i+=5) // Hago un bucle desde 0 al tamaño del array incrementando el índice en 5.
    {
        echo "<script>ids.push(" . $_SESSION['car'][$i] . ");</script>"; // Pongo en los array de javascript los valores en el array de sesión car, la ID del producto seleccionado.
        echo "<script>qtty.push(" . $_SESSION['car'][$i + 1] . ");</script>"; // Pongo la cantidad de artículos seleccionados.
        echo "<script>stock.push(" . $_SESSION['car'][$i + 2] . ");</script>"; // Pongo el stock de artículos disponibles.
        echo "<script>product.push('" . $_SESSION['car'][$i + 3] . "');</script>"; // Pongo el artículo.
        echo "<script>price.push(" . $_SESSION['car'][$i + 4] . ");</script>"; // Pongo el precio.
    }
}

if (isset($_POST["delete"])) // Para Remover un artículo del array de sesión car, hay que eliminar los tres valores: qtty product and price.
{
    $id = $_POST["id"];
    $delete = $_POST["delete"]; // Recibe el índice a borrar.
    $index = $delete * 5; // Multiplico por 5 el índice del artículo a borrar, si es el índice 0 borro el artícuilo en la primera posición, si paso el índice 3 el artículo está en la posición 12.
    $sql = "UPDATE product SET stock=stock + {$_SESSION['car'][$index + 1]} WHERE id=$id"; // Hago un Update del stock del producto quitado del carro, suma.
    $stmt = $conn->prepare($sql); // Preparo la Consulta.
    $stmt->execute(); // La ejecuto.

    unset($_SESSION['car'][$index]); // Borra el índice, corresponde a la ID.
    unset($_SESSION['car'][$index + 1]); // Borra el índice + 1, corresponde a la cantidad.
    unset($_SESSION['car'][$index + 2]); // Borra el índice + 2, corresponde al stock.
    unset($_SESSION['car'][$index + 3]); // Borra el índice + 3, corresponde al producto.
    unset($_SESSION['car'][$index + 4]); // Borra el índice + 4, corresponde al precio.
    $_SESSION["car"] = array_values($_SESSION["car"]); // Arregla los índices del array de sesión car.
    
    clean(); // Llamo a la función clean que pone en los array de javascript los valores de cada producto agregado al carro.
    echo "<script>showCar(" . count($_SESSION['car']) . ");</script>"; // Llamo a la función de javascript showCar() y le paso el tamaño del carro.
}

if (isset($_POST["update"])) // Función para actualizar la cantidad de cada Artículo cuando se modifica dentro del carro de la compra.
{
    $id = $_POST["id"]; // Recibe la ID del artículo.
    $qtty = $_POST["qtty"]; // Recibe la cantidad mosificada.
    for ($i = 0; $i < count($_SESSION["car"]); $i+=5) // Hago un bucle al tamaño del carro de la compra e incremento en 5.
    {
        if ($_SESSION["car"][$i] == $id) // Si en el carro de la compra en la posición 0, 5, 10, 15 etc. está la ID del artículo.
        {
            $_SESSION["car"][$i + 1] = $qtty; // Modifico la cantidad que está es 1, 6, 11, 16 etc. con la cantidad recibida.
        }
    }

    clean(); // Llamo a la función clean que pone en los array de javascript los valores de cada producto agregado al carro.
    echo "<script>showCar(" . count($_SESSION['car']) . ");</script>"; // Llamo a la función de javascript showCar() y le paso el tamaño del carro.
}
include "includes/nav-car.php";
include "includes/nav-mob-car.php";

if (isset($_POST["id"])) // Recibo desde index.php la ID del artículo que seleccioné, también llega la ID del artículo que quito del carro y se vuelve a mostrar en la página el artículo quitado.
{
    clean(); // Llamo a la función clean que pone en los array de javascript los valores de cada producto agregado al carro.
    $id = $_POST["id"];
    $sql = "SELECT * FROM product WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0)
    {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        echo '
        <section class="container-fluid pt-3">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="view1">
                    <br><br>
                    <div class="row">
                    <div class="col-md-6">
                    <h1>Has Seleccionado: ' . $row->product . '</h1>
                    <br>
                    <img class="productimg" src="' . $row->img . '" alt="' . $row->product . '">
                    <h3>Precio: ' . $row->price . ' €</h3>
                    <br><br>
                    <form action="" method="post">
                    <label><select name="qtty"style="width: 300px">';
                    for($i = 1; $i <= $row->stock; $i++)
                    {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select> Cantidad</label><br><br>
                    <input type="hidden" name="id" value="' . $id . '">
                    <input type="hidden" name="stock" value="' . $row->stock . '">
                    <input type="hidden" name="product" value="' . $row->product . '">
                    <input type="hidden" name="price" value="' . $row->price . '">
                    
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                    <br><br><br><br><br>
                    <h5>' . $row->description . '</h5>
                    <br><br><br><br><br>
                    <input type="submit" value="Agrego al Carro de la Compra" class="btn btn-primary">
                    </form>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        </section>';
    }
    else
    {
        echo "<script>toast(1, 'Nada Aun', 'Estamos Preparando el Almacén, Pronto Habrá Mercancía a la Venta.');</script>"; // Muestro el diálogo que aun no hay artículos a la venta.
    }
}
else
{
    echo "<h1>Has llegado aquí por Error.</h1>";
}
echo "<br><br>";
if ($_SESSION["type"][0] == "kind")
{
    echo "<button onclick='window.open(\"search.php?kind=" . $_SESSION["type"][1] . "\", target=\"_self\")' class='btn btn-secondary'>Volver a la Página de tu Elección</button>";
}
else
{
    echo "<button onclick='window.open(\"search.php?brand=" . $_SESSION["type"][1] . "\", target=\"_self\")' class='btn btn-secondary'>Volver a la Página de tu Elección</button>";
}
?>
<br>
<?php
include "includes/footer.html";
?>