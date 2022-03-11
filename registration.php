<?php
$message = "";
if (isset($_POST['signin_button'])) {
    if (isset($_POST['login']) and isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["repeat"])
        and isset($_POST["name"]) and isset($_POST["lastname"]) and isset($_POST["birthday"])) {
        if (strcmp($_POST['login'], "") == 0) {
            $message = "Введите логин";
        } elseif (strcmp($_POST['email'], "") == 0) {
            $message = "Введите email";
        } elseif (strcmp($_POST['password'], "") == 0) {
            $message = "Введите пароль";
        } elseif (strcmp($_POST['repeat'], "") == 0) {
            $message = "Введите повтор пароля";
        } elseif (strcmp($_POST['name'], "") == 0) {
            $message = "Введите имя";
        } elseif (strcmp($_POST['lastname'], "") == 0) {
            $message = "Введите фамилию";
        } elseif (strcmp($_POST['birthday'], "") == 0) {
            $message = "Введите дату рождения";
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9\-_]+$/u", $_POST['login'])) {
            $message = "Логин содержит недопустимые символы";
        } elseif (!preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $_POST['email'])) {
            $message = "Email введён некорректно";
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z]+$/u", $_POST['name'])) {
            $message = "Имя содержит недопустимые символы";
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z]+$/u", $_POST['lastname'])) {
            $message = "Фамилия содержит недопустимые символы";
        } elseif (isset($_POST["patronymic"]) and !preg_match("/^[а-яА-ЯёЁa-zA-Z ']*$/u", $_POST['patronymic'])) {
            $message = "Отчество содержит недопустимые символы";
        } elseif (strtotime($_POST["birthday"]) === false) {
            $message = "Некорректно заданна дата рождения";
        } elseif (strtotime($_POST["birthday"]) >= time()) {
            $message = "Некорректно заданна дата рождения";
        } elseif (strcmp($_POST['password'], $_POST["repeat"]) != 0) {
            $message = "Пароли не совпадают";
        } else {
            $patronymic = (isset($_POST["patronymic"])) ? $_POST["patronymic"] : "";
            $birthday = strtotime($_POST["birthday"]);
            require_once("db_authorization.php");
            $db = connect_db("User") or die();
            $result = signin($db, $_POST['login'], $_POST['email'], $_POST['password'], $_POST['name'],
                $_POST['lastname'], $patronymic, $birthday);
            mysqli_close($db);
            $success = $result[0];
            $message = $result[1];
            if ($success) {
                header("Location: authorization.php");
                exit;
            }
        }
    } else {
        $message = "Заполните необходимые поля";
    }
}

require_once("templates.php");
show_header();
?>
<h2>Регистрация</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Логин:</td>
            <td><input type="text" class="b2" name="login" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" class="b2" name="email" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" class="b2" name="password" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Повтор пароля:</td>
            <td><input type="password" class="b2" name="repeat" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td><input type="text" class="b2" name="name" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td><input type="text" class="b2" name="lastname" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td><input type="text" class="b2" name="patronymic" size="15" maxlength="64"></td>
        </tr>
        <tr>
            <td>Дата рождения:</td>
            <td><input type="date" class="b2" name="birthday" size="15"></td>
        </tr>
        </tbody>
    </table>
    <input type="submit" class="b2" name="signin_button" value="Зарегистрироваться">
    <br>
    <br>
    <?php print($message); ?>
</form>
