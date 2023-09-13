<?php
'unzip nutra.zip';
?>


<?php // Conexión con la base de datos en PDO.
session_start(); // Incluyo el session_start() ya que se usará en casi todos los scripts.
try // Intenta la conexión
{
	$conn = new PDO('mysql:host=fdb32.atspace.me;dbname=3865745_nutraproject', "3865745_nutraproject", "Anubis68");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) // En caso de error
{
	echo 'Error: ' . $e->getMessage(); // Muestra el error.
}
?>