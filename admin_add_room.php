<?php
require_once("templates.php");
show_header();
?>
<h2>Добавление комнаты</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Номер комнаты:</td>
            <td><input type="text" class="b2" name="number" size="15" maxlength="64"></td>
        </tr>
        </tbody>
    </table>
    <br>
    <input type="submit" class="b2" name="add_button" value="Добавить">
    <br>
    <br>
    <?php
    require_once("db_reservation.php");
    $db = connect_db("Admin") or die();
    if (isset($_POST['add_button'])) {
        if (isset($_POST['number'])) {
            if (strcmp($_POST['number'], "") == 0) {
                print("Введите номер комнаты");
            } elseif (!is_numeric($_POST['number'])) {
                print("Номер комнаты должен быть числом");
            } elseif (!room_number_is_free($db, $_POST["number"])) {
                print("Комната с таким номером уже есть");
            } else {
                $result = add_room($db, $_POST["number"]);
                if ($result) {
                    print("Комната успешно добавлена");
                }
            }
        } else {
            print("Заполните поля");
        }
    }
    mysqli_close($db);
    ?>
</form>