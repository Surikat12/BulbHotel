<?php
require_once("templates.php");
show_header();

$orders = array("number" => "Номер комнаты");
show_sort_bar($orders);
if (isset($_GET["show_button"])) {
    require_once("db_reservation.php");
    $db = connect_db("Admin") or die();
    $rooms = get_rooms($db, $_GET["order"], $_GET["desc"]);
    mysqli_close($db);
    if ($rooms === false) {
        die();
    }
    if (count($rooms) == 0) {
        print("Комнат нет");
    } else {
        ?>
        <h2>Комнаты</h2>
        <table class="show_table">
            <thead>
            <tr>
                <td>Номер</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($rooms as $room) {
                echo "<tr>";
                echo "<td>" . $room . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>
