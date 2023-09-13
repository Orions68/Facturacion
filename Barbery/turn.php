<?php
include "includes/conn.php";
$title = "Turnos - La Peluquería de Javier Borneo";
include "includes/header.php";
include "includes/modal-profile.html";
include "includes/nav_profile.php";
include "includes/nav-mob-profile.php";
$id = $_POST['id'];
$date = $_POST['date'];
$time = $_POST['time'];

$stmt = $conn->prepare("SELECT name FROM client WHERE id='$id'");
$stmt->execute();
if ($stmt->rowCount() > 0)
{
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$name = $row->name;
	$stmt = $conn->prepare("UPDATE client SET date='$date', time='$time' WHERE id=$id");
	$stmt->execute();
	// echo "<script>if (!alert('Turno del Cliente: " . $name . " Registrado.')) window.open('profile.php', '_self')</script>";
	echo "<script>toast(0, 'Turno del Cliente: " . $name . "', ' Registrado.');</script>";
}

echo "Tu Turno es el día: " . $data . " a las: " . $time . " Hs.";
echo "<br>";
?>
<script>screenSize();</script>
<script>screen();</script>
<!-- Script para detectar si la pantalla modifica su tamaño horizontal -->
<script>
    window.addEventListener('resize', screen);
    screen();
</script>
</body>
</html>