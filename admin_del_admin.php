<?php
require_once("templates.php");
show_header();
?>
<h2>Удаление администратора</h2>
<form class="long_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Администратор:</td>
            <td><select name="admins">
                    <?php
                    session_start();
                    require_once("db_authorization.php");
                    $db = connect_db("Admin") or die();
                    $admins = get_admins($db, "nickname", false);
                    if ($admins === false) {
                        die();
                    }
                    $deleted_admin = "";
                    if (isset($_POST["admins"])) {
                        $deleted_admin = $_POST["admins"];
                    }
                    foreach ($admins as $admin) {
                        if (strcmp($_SESSION["nickname"], $admin) != 0 and strcmp($deleted_admin, $admin) != 0) {
                            echo "<option value=" . $admin . " > " . $admin . "</option>";
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
        $result = delete_admin($db, $_POST["admins"]);
        if ($result) {
            print("Администратор удалён");
        }
    }
    mysqli_close($db);
    ?>
</form>
