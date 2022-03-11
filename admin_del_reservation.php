<?php
require_once("templates.php");
show_header();
?>
<h2>Удаление брони</h2>
<form class="short_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>ID:</td>
            <td><select name="reservations">
                    <?php
                    require_once("db_reservation.php");
                    $db = connect_db("Admin") or die();
                    $reservations = get_reservations($db, "id", false);
                    if ($reservations === false) {
                        die();
                    }
                    $deleted_reservation = "";
                    if (isset($_POST["reservations"])) {
                        $deleted_reservation = $_POST["reservations"];
                    }
                    foreach ($reservations as $reservation) {
                        if (strcmp($deleted_reservation, $reservation["id"]) != 0) {
                            echo "<option value=" . $reservation["id"] . " > " . $reservation["id"] . "</option>";
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
        $result = delete_reservation($db, (int)$_POST["reservations"]);
        if ($result) {
            print("Бронь удалена");
        }
    }
    mysqli_close($db);
    ?>
</form>
