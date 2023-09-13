<?php // Script para eliminar un perfil de alumno.
include "includes/conn.php";

if (isset($_POST["id"])) // Si se recibe la id del alumno.
{
    $id = $_POST["id"];
    $sql = "DELETE FROM client WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) // Lo borró de la base de datos.
    {
        session_destroy(); // Destruyo la sesión
        echo "<script>if (!alert('Se Ha Eliminado Tu Perfil, Gracias por Haber Sido Parte de Salón de Estética Joana.')) window.open('index.php', '_self');</script>"; // Muestro una alerta, se ha eliminado.
    }
}
else // Si no llegaron datos por POST.
{
    echo "<script>if (!alert('Llegaste Aquí por Error, No Hay Nada Interesante en esta Página, es de Uso Interno.')) window.open('index.php', '_self');</script>"; // Nada se ha eliminado.
}
?>