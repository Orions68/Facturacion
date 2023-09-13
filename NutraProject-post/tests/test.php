<?php
if (empty($_SESSION["any"]))
{
    $_SESSION["any"] = [];
    array_push($_SESSION["any"], 1);
    array_push($_SESSION["any"], "Hola");
    array_push($_SESSION["any"], 2.5);
}
$array = array(9, "Chau", 8.7);
$array2 = json_encode($array);
// $array3 = implode(",", $array);
$array3 = implode(",", $_SESSION["any"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Things</title>
</head>
<body>
    <h1>Vamo a probá a ve si funca</h1>
    <br><br>
    <button onclick="ver()">Obtener Datos</button>
    <br>
    <br>
    <h3 id="here"></h3>
    <h4 id="hore"></h4>
    <form action="otro.php" method="post">
        <div id="container">
            <label><input type="text" name="data"> Pon algo aquí</label>
            <br><br>
            <input type="submit" value="Envia">
        </div>
    </form>


    <script>
        function ver()
        {
            let here = document.getElementById("here");
            let hore = document.getElementById("hore");
            here.innerHTML = <?php echo count($_SESSION['any']); ?>;
            hore.innerHTML = <?php echo $_SESSION['any'][0]; ?> + ", " + <?php echo json_encode($_SESSION['any'][1]); ?> + ", " + <?php echo $_SESSION['any'][2]; ?>;
            // hore.innerHTML = <?php echo $array[0]; ?> + ", " + <?php echo json_encode($array[1]); ?> + ", " + <?php echo $array[2]; ?>;
        }
    </script>
</body>
</html>