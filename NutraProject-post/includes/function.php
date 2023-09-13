<?php
function result($conn, $row) // Función result recibe la conexión, las filas de la base de datos $row y un 1 o un 0 para saber de donde se llama.
{
    global $price, $partial, $product, $qtty;

    $qttyArray = explode(",", $row->qtty);
    $productArray = explode(",", $row->product_id);
    $partialArray = explode(",", $row->partial);

    for ($i = 0; $i < count($productArray) - 1; $i++)
    {
        $eacharticle[$i] = explode(",", $productArray[$i]);
        if ($i == count($productArray) - 2)
        {
            $qtty .= $qttyArray[$i];
            $partial .= $partialArray[$i] . " €";
        }
        else
        {
            $qtty .= $qttyArray[$i] . "<br>";
            $partial .= $partialArray[$i] . " €<br>";
        }
    }

    for ($i = 0; $i < count($productArray) - 1; $i++)
    {
        $sql_product = "SELECT product, price FROM product WHERE id=" . $eacharticle[$i][0];
        $stmt = $conn->prepare($sql_product);
        $stmt->execute();
        $row_product = $stmt->fetch(PDO::FETCH_OBJ);
        $product_name = $row_product->product;
        $product_price = $row_product->price;
        if ($i == count($productArray) - 2)
        {
            $product .= $product_name;
            $price .= $product_price . " €";
        }
        else
        {
            $product .= $product_name . "<br>"; // Saltos de línea HTML.
            $price .= $product_price . " €<br>";
        }
    }
}

function getClient($conn, $id)
{
    if ($id == null)
    {
        return "Consumidor Final";
    }
    else
    {
        $sql = "SELECT name FROM client WHERE id=$id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->name;
    }
}
?>