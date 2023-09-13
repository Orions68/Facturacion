<?php
function getName($conn, $id, $who)
{
    if ($who == "P")
    {
        $sql = "SELECT name FROM patient WHERE id=$id;";
    }
    else
    {
        $sql = "SELECT name FROM doctor WHERE id=$id;";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    return $row->name;
}
?>