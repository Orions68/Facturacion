<?php
if (isset($_POST["data"]))
{
    $data = $_POST["data"];
    echo $data;
}
if (isset($_POST["username"]))
{
    echo $_POST["username"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="form" action="" method="post">
        <img src="../img/protein.webp" alt="Imagen" style="cursor: pointer;" width="320" heigth="240" onclick="document.getElementById('form').submit()">
        <br>
        <label><input type="text" name="username"> Nombre de Usuario.</label>
        <br><br>
        <input type="submit" value="Envia">
    </form>
</body>
</html>