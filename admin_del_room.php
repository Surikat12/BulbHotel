<?php
require_once("templates.php");
show_header();
?>
<h2>Удаление комнаты</h2>
<form class="short_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Комната:</td>
            <td><select name="rooms">
                    <?php
                    require_once("db_reservation.php");
                    $db = connect_db("Admin") or die();
                    $rooms = get_rooms($db, "number", false);
                    if ($reservations === false) {
                        die();
                    }
                    $deleted_room = "";
                    if (isset($_POST["rooms"])) {
                        $deleted_room = $_POST["rooms"];
                    }
                    foreach ($rooms as $room) {
                        if (strcmp($deleted_room, $room) != 0) {
                            echo "<option value=" . $room . " > " . $room . "</option>";
                        }
                    }
                    ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="submit" class="b2" name="del_button" value="Удалить"></td>
        </tr>
        </tbody>
    </table>
    <?php
    if (isset($_POST['del_button'])) {
        $result = delete_room($db, (int)$_POST["rooms"]);
        if ($result) {
            print("Комната удалена");
        }
    }
    mysqli_close($db);
    ?>
</form>
