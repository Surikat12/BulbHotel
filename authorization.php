<?php
$message = "";
if (isset($_POST['login_button'])) {
    if (isset($_POST['login']) and isset($_POST['password'])) {
        if (strcmp($_POST['login'], "") == 0) {
            $message = "Введите логин";
        } elseif (strcmp($_POST['password'], "") == 0) {
            $message = "Введите пароль";
        } else {
            session_start();
            require_once("db_authorization.php");
            $db = connect_db("Admin") or die();
            $result = login($db, $_POST['login'], $_POST['password']);
            mysqli_close($db);
            $type = $result[0];
            $message = $result[1];
            if ($type) {
                $_SESSION["nickname"] = $_POST["login"];
                $_SESSION["type"] = $type;
                header("Location: main.php");
                exit;
            }
        }
    } else {
        $message = "Заполните поля";
    }
}

require_once("templates.php");
show_header();
?>
<h2>Авторизация</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td><label>Логин:</label></td>
            <td><input class="txa" type="text" name="login"/></td>
        </tr>
        <tr>
            <td><label>Пароль:</label></td>
            <td><input class="txa" type="password" name="password"/></td>
        </tr>
        </tbody>
    </table>
    <input class="aa" type="submit" name="login_button" value="Войти">
    <br>
    <br>
    <?php print($message); ?>
</form>
<br>
<form class="default_form" method="post">
    <a class="btt" href="registration.php">Зарегистрироваться</a>
</form>
