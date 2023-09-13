<?php
session_start();
ob_start();
try
{
	$conn = new PDO('mysql:host=localhost;dbname=id19794148_fernando', "id19794148_root", "Osvaldo@1968");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo 'Error: ' . $e->getMessage();
}
?>