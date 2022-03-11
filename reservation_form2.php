<?php

$booked_room = "";
if (isset($_POST["rooms"])) {
    $booked_room = $_POST["rooms"];
}

$start_date = strtotime($_GET["start_date"]);
$end_date = strtotime($_GET["end_date"]);
$rooms = get_suitable_rooms($db, $start_date, $end_date);
if ($rooms === false) {
    die();
}
if (count($rooms) == 0) {
    print("Подходящих номеров не найдено");
    echo "</form>";
} else {
?>
    </form>
    <br>
    <form class="default_form" method="post">
        <table class="default_table">
            <tr>
                <td>Номер:</td>
                <td><select name="rooms">
                        <?php
                        foreach ($rooms as $room) {
                            if (strcmp($room, $booked_room) != 0) {
                                echo "<option value=" . $room . " > " . $room . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php
    if (isset($_COOKIE[session_name()]) and strcmp($_COOKIE[session_name()], "") != 0) {
        ?>
        <input type="submit" class="b2" name="reservation_button" value="Забронировать номер">
        <br>
        <br>
    <?php
    } else {
        ?>
        Только зарегистрированные пользователи могут бронировать номера
        <?php
        }
}
?>