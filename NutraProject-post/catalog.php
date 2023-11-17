<?php
$ok = false; // Variable usada para verificar si hay datos o no.
$i = 0; // Índice de los Detalles de los productos
$k = 0; // Índice de los productos.
$product = []; // Arrays que contienen los datos de los artículos.
$path = []; // Ruta de las imágenes de los artículos.
$id = [];
$price = [];
$qtty = [];
$kind1 = [];
$brand1 = [];

function fromIndex($conn) // Esta función se llama desde index.php y recibe la conexión con la base de datos.
{
    global $ok, $product, $path, $qtty; //$places, $sold; // Declaro globales las variables que necesito en la función.
    lookproducts($conn, "", ""); // Llamo a la función lookproducts(), pasándole la conexión y dos valores vacios, ya que también se usa para buscar por tipo de producto y por marca.
    if ($ok) // Si lo que pasa en la función lookproducts() pone la variable global $ok a true;
    {
        $size = count($product); // Asigno a la variable $size el tamaño del array $product.

        if ($size > 6) // Si hay más resultados que 6.
        {
            $size = 6; // Solo voy a mostrar 6.
        }
        echo "<div class='row'>"; // Pongo en pantalla un elemento div de la clase row de Bootstrap.
        if ($size < 4) // Verifico si la cantidad de datos a mostrar es menor que 4.
        {
            for ($i = 0; $i < $size; $i++) // Si es así, hago un bucle a la cantidad de datos a mostrar - 1, $size puede valer desde 1 a 3, $i va de 0 a 2.
            {
                if ($qtty[$i] > 0) // Verifico si aun hay unidades del producto en el que estoy.
                {
                    show($i);
                }
            }
            echo "</div>"; // Cierro el div de la fila de Bootstrap.
        }
        else // Si $size es mayor que 3, hay más de 3 productos para mostrar.
        {
            for ($i = 0; $i < 3; $i++) // Hago un bucle de 0 a 2, aquí muestro los primeros 3.
            {
                if ($qtty[$i] > 0)
                {
                    show($i);
                }
            }
            echo "</div>"; // Cierro el div de la fila de Bootstrap.
            echo "<div class='row' style='height: 20px;'></div>"; // Abro una fila de Bootstrap intermedia para separar los resultados, 20 pixels de espacio vertical.
            echo "<div class='row'>"; // Abro una segunda fila de Bootstrap.
            for ($i = 3; $i < $size; $i++) // Hago un bucle desde 3 a la cantidad de productos -1, contenidos en la variable $size.
            {
                if ($qtty[$i] > 0)
                {
                    show($i);
                }
            }
            echo "</div>"; // Cierro el div de la segunda fila de Bootstrap.
        }
    }
    else // Si no hubo resultados.
    {
        echo "<script>toast(1, 'Nada Por Ahora', 'Aun No Hay Productos Publicados.');</script>"; // Aun no hay productos.
    }
}

function fromSearch($conn, $which, $selected) // Esta función se llama desde el script search.php, recibe la conexión, el tipo/marca y si la selección fue por tipo o por marca.
{
    global $ok, $id, $product, $price, $path, $qtty; //$places, $sold; // Declaro globales las variables que necesito en la función.
    lookproducts($conn, $which, $selected); // Llamo a la función lookproducts(), pasándole la conexión, el tipo/marca y si hay que buscar por tipo o por marca.
    if ($ok) // Si el resultado de la función lookproducts devolvió algo.
    {
        echo "<script>var id = [];</script>"; // Declaro las variables de javascript que contendrán los datos de los artículos.
        echo "<script>var product = [];</script>";
        echo "<script>var price = [];</script>";
        echo "<script>var qtties = [];</script>";
        echo "<script>var path = [];</script>";
        for ($i = 0; $i < count($id); $i++) // Hago un bucle al tamaño de los arrays de artículos.
        {
            echo "<script>id[" . $i . "] = '" . $id[$i] . "';</script>"; // Asigno los valores de los datos que tengo en las variables de php a los arrays de javascript.
            echo "<script>product[" . $i . "] += '" . $product[$i] . "';</script>";
            echo "<script>price[" . $i . "] += '" . $price[$i] . "';</script>";
            echo "<script>qtties[" . $i . "] = '" . $qtty[$i] . "';</script>";
            echo "<script>path[" . $i . "] = '" . $path[$i] . "';</script>";
        }
        ?>
        <div id="container"></div>
        <br>
        <span id="page"></span>&nbsp;&nbsp;&nbsp;&nbsp;
        <button onclick="prev(false)" id="prev" class="btn btn-danger" style="visibility: hidden;">Anteriores Resultados</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button onclick="next(false)" id="next" class="btn btn-primary" style="visibility: hidden;">Siguientes Resultados</button><br>
        <script>change(1, 6, false);</script> <!-- Llama a la función de javascript que muestra los resultados de los artículos en pantalla, se le pasa el número de página, la cantidad de artículos a mostrar por página y de donde se llama a la función. -->
        <?php
    }
    else // Si no hubo resultados.
    {
        echo "<script>toast(1, 'Nada Por Ahora', 'Aun No Hay Productos Publicados de ese Grupo o Marca.');</script>"; // Aun no hay productos.
    }
}

function lookproducts($conn, $which, $selected) // Esta función hace la consulta a la base de datos, recibe la conexión, el tipo/marca y si tiene que buscar por tipo o por marca.
{
    global $ok, $i, $k, $kind1, $brand1, $product, $path, $id, $price, $qtty; // Hago globales todas las variables que necesita la función.
    if ($selected == "") // Si la busqueda por tipo o por marca está vacía, se llamo desde index.php.
    {
        $sql = "SELECT * FROM product GROUP BY kind"; // Consulto a la base de datos todos los resultados agrupados por tipo de producto, se llamó desde index.php.
    }
    else // Si no, se llamo desde search.php.
    {
        if ($selected == 1) // Si $selected es 1, busca por tipo.
        {
            $sql = "SELECT * FROM product WHERE kind='$which'"; // Consulto a la base de datos todos los tipos de productos.
        }
        else // Si $selected no es 1, busca por marca.
        {
            $sql = "SELECT * FROM product WHERE brand='$which'"; // Consulto a la base de datos todas las marcas de productos.
        }
    }
    $stmt = $conn->prepare($sql); // Hago la conexión a la base de datos.
    $stmt->execute(); // La ejecuto.
    if ($stmt->rowCount() > 0) // Si hay resultados.
    {
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) // Cargo en la variable $row todos los campos del resultado de la consulta.
        {
            $kind1[$i] = $row->kind; // Asigno al array $kind1[$i] la fila $row->kind, que contiene los tipos de productos de los que se trata.
            $brand1[$i] = $row->brand; // Cargo las marcas de los productos.
            $product[$i] = $row->product; // Cargo los datos de los productos en arrays.
            $path[$i] = $row->img;
            $id[$i] = $row->id;
            $i++; // Incremento el indice $i.
        }

        for ($j = 0; $j < $i; $j++) // Hago un bucle a la cantidad de datos encontrados(el indice $i).
        {
            $sql = "SELECT * FROM product WHERE id = $id[$j]"; // Preparo una consulta a la tabla products de los productos por su ID según su marca o tipo, seleccionado por el cliente.
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) // Si hay resultados.
            {
                while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                {
                    $id[$k] = $row->id;
                    $price[$k] = $row->price;
                    $qtty[$k] = $row->stock;
                    $k++;
                }
            }
        }
        $ok = true; // Pongo $ok a true.
    }
    else // Si no se encotnró ningún resultado en la base de datos.
    {
        $ok = false; // Pongo $ok a false.
    }
}

function show($i) // Muestra los Artículos que están en la base de datos.
{
    global $id, $path, $product, $qtty;
    echo "<div class='col-md-4'>
    <a href='info.php?id=" . $id[$i] . "'><img id='img" . $i . "' src='" . $path[$i] . "' alt='" . $product[$i] . "' class='mysize' onmouseover='changeSize(this.id, true)' onmouseout='changeSize(this.id, false)'>
    <br>"; // Pongo en pantalla un div con la clase col de Bootstrap(4 columnas), y un enlace a la página info.php pasándole por GET el tipo de producto de que se trata, con la imagen del producto.
    echo "<small class='btn btn-info' role='button'>Ver Características del producto</small></a>"; // Pongo en pantalla un elemento small con una leyenda y cierro el enlace.
    leftUnits($qtty[$i]); // Llamo a la función leftUnits() pasándole la cantidad de artículos que quedan y verifico si en algún producto quedan menos de 10 unidades.
    echo "</div>"; // Si hay stock se muestra el producto en pantalla, si $left[$i] fuera menor o igual a 0 no se muestra el producto, cierro el div.
}

function leftUnits($left) // Muestra cuantas unidades quedan, recibe la cantidad de unidades que quedan.
{
    if ($left < 10) // Si quedan menos de 10
    {
        echo "<div class='leftunits'>QUEDAN " . $left . " UNIDADES</div><br><br><br>"; // Muestro un aviso rojo avisando que quedan pocas unidades y hago 3 saltos de línea.
    }
    else
    {
        echo "<br>"; // Si el stock es 10 o más, hago un salto de línea.
    }
}
?>