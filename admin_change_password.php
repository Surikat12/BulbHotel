<?php
require_once("templates.php");
show_header();
?>
<h2>Изменение пароля</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Старый пароль:</td>
            <td><input type="password" class="b2" name="old_password" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Новый пароль:</td>
            <td><input type="password" class="b2" name="new_password" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Повтор пароля:</td>
            <td><input type="password" class="b2" name="repeat" size="15" maxlength="64"></td>
        </tr>
        </tbody>
    </table>
    <br>
    <input type="submit" class="b2" name="change_button" value="Сменить пароль">
    <br>
    <br>
    <?php
    if (isset($_POST['change_button'])) {
        if (isset($_POST['old_password']) and isset($_POST["new_password"]) and isset($_POST["repeat"])) {
            if (strcmp($_POST['old_password'], "") == 0) {
                print("Введите старый пароль");
            } elseif (strcmp($_POST['new_password'], "") == 0) {
                print("Введите новый пароль");
            } elseif (strcmp($_POST["repeat"], "") == 0) {
                print("Введите повтор пароля");
            } elseif (strcmp($_POST['new_password'], $_POST["repeat"]) != 0) {
                print("Пароли не свопадают");
            } else {
                session_start();
                require_once("db_authorization.php");
                $db = connect_db("Admin") or die();
                $result = change_admin_password($db, $_SESSION["nickname"], $_POST["old_password"], $_POST["new_password"]);
                mysqli_close($db);
                if ($result) {
                    print("Пароль успешно изменён");
                }
            }
        } else {
            print("Заполните все поля");
        }
    }
    ?>
</form>
