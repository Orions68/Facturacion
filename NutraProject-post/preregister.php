<?php
include "includes/conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting</title>
</head>
<body>
    <br><br><br><br><br><br><br><br><br><br>
    <?php
    if (empty($_SESSION["client"]))
    {
        echo'<h1 id="timer">Serás redirigido en 4 segundos.</h1>';
    }
    else
    {
        echo'<h1 id="timer">Serás redirigido en 0 segundos.</h1>';
    }
    ?>
    <script>
        let timer = document.getElementById("timer");
        var number = 4;
        function wait()
        {
            setTimeout(function() {
                if (number > 0)
                {
                    number--;
                    timer.innerHTML = "Serás redirigido en " + number + " segundos.";
                    wait();
                }
            },1000)
        }
        wait();
    </script>
    <?php
    if (isset($_POST["email"]))
    {
        $name = $_POST["username"];
        $surname = $_POST["surname"];
        $surname2 = $_POST["surname2"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $array = explode("@", $email);
        $_SESSION["save"] = $array[0];
        $pass = $_POST["pass"];
        $bday = $_POST["bday"];
        $filename = $array[0] . "register.txt";
        if (!file_exists($filename))
        {
            $file = fopen($filename, "w") or die("Unable to open file!");
            fwrite($file, $name);
            fwrite($file, ";");
            fwrite($file, $surname);
            fwrite($file, ";");
            fwrite($file, $surname2);
            fwrite($file, ";");
            fwrite($file, $address);
            fwrite($file, ";");
            fwrite($file, $phone);
            fwrite($file, ";");
            fwrite($file, $email);
            fwrite($file, ";");
            fwrite($file, $pass);
            fwrite($file, ";");
            fwrite($file, $bday);
            fwrite($file, ";");
        }
        fclose($file);
        $response["error"] = false;
        echo json_encode($response);
        exit();
    }
    if (empty($_SESSION["client"]))
    {
        $_SESSION["client"] = -1;
    }
    else
    {
        $email = $_SESSION["save"];
        session_destroy();
        $filename = $email . "register.txt";
        $file = fopen($filename, "r") or die("Unable to open file!");
        $data = fread($file, filesize($filename));
        $array = explode(";", $data);
        fclose($file);
        echo '<form name="data" method="post" action="register.php">';
        echo '<input type="hidden" name="username" value="' . $array[0] . '">';
        echo '<input type="hidden" name="surname" value="' . $array[1] . '">';
        echo '<input type="hidden" name="surname2" value="' . $array[2] . '">';
        echo '<input type="hidden" name="address" value="' . $array[3] . '">';
        echo '<input type="hidden" name="phone" value="' . $array[4] . '">';
        echo '<input type="hidden" name="email" value="' . $array[5] . '">';
        echo '<input type="hidden" name="pass" value="' . $array[6] . '">';
        echo '<input type="hidden" name="bday" value="' . $array[7] . '">';
        echo '</form>';
        echo '<script type="text/javascript">document.forms["data"].submit();</script>';
    }
    ?>
</body>
</html>