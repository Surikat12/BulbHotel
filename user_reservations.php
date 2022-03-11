<?php
require_once("templates.php");
show_header();

$orders = array("id" => "ID", "room_number" => "Номер комнаты",
    "Reservations.start_date" => "Дата начала", "Reservations.end_date" => "Дата конца");
show_sort_bar($orders);

if (isset($_GET["show_button"])) {
    require_once("db_reservation.php");
    $db = connect_db("User") or die();
    $rooms = get_user_rooms($db, $_SESSION["nickname"], $_GET["order"], $_GET["desc"]);
    mysqli_close($db);
    if ($rooms === false) {
        die();
    } else {
        if (count($rooms) == 0) {
            print("Вы не бронировали номеров");
        } else {
            ?>
            <h2>Забронированные вами номера</h2>
            <table class="show_table">
            <thead>
            <tr>
                <td>ID</td>
                <td>Номер комнаты</td>
                <td>Дата начала</td>
                <td>Дата конца</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($rooms as $room) {
                echo "<tr>";
                echo "    <td>" . $room["id"] . "</td>";
                echo "    <td>" . $room["room_number"] . "</td>";
                echo "    <td>" . $room["start_date"] . "</td>";
                echo "    <td>" . $room["end_date"] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
            <?php
        }
    }
}
?>