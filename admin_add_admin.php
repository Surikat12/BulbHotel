<?php
require_once("templates.php");
show_header();
?>
<h2>Добавление администратора</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Логин:</td>
            <td><input type="text" class="b2" name="login" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" class="b2" name="password" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Повтор пароля:</td>
            <td><input type="password" class="b2" name="repeat" size="15" maxlength="64"></td>
        </tr>
        </tbody>
    </table>
    <br>
    <input type="submit" class="b2" name="add_button" value="Добавить">
    <br>
    <br>
    <?php
    if (isset($_POST['add_button'])) {
        if (isset($_POST['login']) and isset($_POST["password"]) and isset($_POST["repeat"])) {
            if (strcmp($_POST['login'], "") == 0) {
                print("Введите логин");
            } elseif (strcmp($_POST['password'], "") == 0) {
                print("Введите пароль");
            } elseif (strcmp($_POST['repeat'], "") == 0) {
                print("Введите повтор пароля");
            } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9\-_]+$/u", $_POST['login'])) {
                print("Логин содержит недопустимые символы");
            } elseif (strcmp($_POST['password'], $_POST["repeat"]) != 0) {
                print("Пароли не совпадают");
            } else {
                require_once("db_authorization.php");
                $db = connect_db("Admin") or die();
                $result = add_admin($db, $_POST['login'], $_POST['password']);
                mysqli_close($db);
                if ($result) {
                    print("Администратор успешно добавлен");
                }
            }
        } else {
            print("Заполните все поля");
        }
    }
    ?>
</form>
