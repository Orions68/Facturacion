<?php
function getClient($conn, $id)
{
    $sql = "SELECT name FROM patients WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    $patient = $row->name;
    return $patient;
}
?>