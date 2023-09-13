<?php
include "includes/conn.php";
$title = "Verificando Disponibilidad";
include "includes/header.php";
include "includes/modal.html";
?>
<section class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php
                if (isset($_POST["datein"]))
                {
                    $dateIn = $_POST["datein"];
                    $dateOut = $_POST["dateout"];
                    echo "
                        <h3>Fecha de Entrada: $dateIn</h3>
                        <br>
                        <h3>Fecha de Salida: $dateOut</h3>
                        <br><br>
                    ";
                    $index = 0;
                    $rooms = [];
                    $room[0] = $index;
                    $sql = "SELECT *, room.ID AS room_number FROM room JOIN date ON room.ID=date.room_id WHERE datein='$dateIn' OR datein<$dateIn AND dateout<$dateOut AND dateout>$dateIn OR datein<$dateIn AND dateout>$dateOut OR datein>$dateIn AND dateout<$dateOut OR datein>$dateIn AND dateout>$dateOut ORDER BY room_id ASC;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0)
                    {
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                        {
                            $rooms[$index] = $row->room_number;
                            $index++;
                        }
                    }
                    allRooms($conn, --$index, $rooms);
                }

                function allRooms($conn, $index, $rooms)
                {
                    $count = 0;
                    $limit = 10;
                    $i = 0;
                    $sql = "SELECT * FROM room;";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0)
                    {
                        while ($row = $stmt->fetch(PDO::FETCH_OBJ))
                        {
                            if ($row->ID == $rooms[$count])
                            {
                                $count++;
                                if ($count > $index)
                                {
                                    $count = 0;
                                }
                            }
                            else
                            {
                                $room[$i] = $row->ID;
                                $path[$i] = $row->path;
                                $i++;
                            }
                        }
                    }
                    head();
                    for ($i = 0; $i < count($room); $i++)
                    {
                        body($room[$i], $path[$i]);
                        $limit--;
                        if ($limit == 0)
                        {
                            echo '</div><br><br><div class="row">';
                            $limit = 10;
                        }
                    }
                    footer();
                }

                function head()
                {
                    echo '
                        <form action="reserve.php" method="post" onsubmit="return verify()">
                            <label><input type="text" name="client" required> Nombre del Cliente</label>
                            <br><br>
                            <label><input id="dni" type="text" name="dni" required> D.N.I. del Cliente</label>
                            <br><br><br>
                            <div class="row">
                        ';
                }

                function body($room, $path)
                {
                    echo '<div class="col-md-1"><label><input type="radio" name="room" value="' . $room . '" required>Habitación ' . $room . '<img src="' . $path . '" alt="Foto de la Habitación" width="140">Para dos personas</label></div>
                    ';
                }

                function footer()
                {
                    echo '</div>
                        <input type="submit" value="Reserva esta Habitación">
                    ';
                }
                ?>
            </div>
        <div class="col-md-1"></div>
    </div>
<section>