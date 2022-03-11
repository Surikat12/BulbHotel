<?php
require_once("templates.php");
show_header();
?>
<h2>Удаление пользователя</h2>
<form class="long_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Пользователи:</td>
            <td><select name="users">
                    <?php
                    require_once("db_authorization.php");
                    $db = connect_db("Admin") or die();
                    $users = get_users($db, "nickname", false);
                    if ($reservations === false) {
                        die();
                    }
                    $deleted_user = "";
                    if (isset($_POST["users"])) {
                        $deleted_user = $_POST["users"];
                    }
                    foreach ($users as $user) {
                        if (strcmp($deleted_user, $user) != 0) {
                            echo "<option value=" . $user . " > " . $user . "</option>";
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
        $result = delete_user($db, $_POST["users"]);
        if ($result) {
            print("Пользователь удалён");
        }
    }
    mysqli_close($db);
    ?>
</form>
