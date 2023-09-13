<?php
include "includes/conn.php";
$title = "Citas - Salón de Estética Le Cabín";
include "includes/header.php";
include "includes/nav_profile.php";

$id = $_POST['id'];
$date = $_POST['date'];
$time = $_POST['time'];

$stmt = $conn->prepare("SELECT name FROM client WHERE id=$id;");
$stmt->execute();
if ($stmt->rowCount() > 0)
{
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$name = $row->name;
	$stmt = $conn->prepare("UPDATE client SET date='$date', time='$time' WHERE id=$id;");
	$stmt->execute();
	echo "<script>toast(0, 'Cita Registrada', 'La Cita del Cliente: " . $name . " ha Sido Registrada.')) window.open('profile.php', '_self')</script>";
}

echo "<h3>Tu Cita es el día: " . $data . " a las: " . $time . " Hs.</h3>";
echo "<br>";
include "includes/footer.html";
?>