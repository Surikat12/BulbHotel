<?php
require_once("templates.php");
show_header();

require_once("db_authorization.php");
session_start();
$db = connect_db("User") or die();
$info = get_user_info($db, $_SESSION["nickname"]) or die();

$nickname = $_SESSION["nickname"];
$email = $info["email"];
$name = $info["name"];
$lastname = $info["lastname"];
$patronymic = $info["patronymic"];
$birthday = strtotime($info["birthday"]);

if (isset($_POST['login'])) {
    $nickname = $_POST['login'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["lastname"])) {
    $lastname = $_POST["lastname"];
}
if (isset($_POST["patronymic"])) {
    $patronymic = $_POST["patronymic"];
}
if (isset($_POST["birthday"])) {
    $birthday = strtotime($_POST["birthday"]);
}
?>
<h2>Изменение информации</h2>
<form class="default_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Логин:</td>
            <td><input type="text" class="b2" name="login" size="15" maxlength="64"
                       value="<?php echo $nickname; ?>"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" class="b2" name="email" size="15" maxlength="64" value="<?php echo $email; ?>"></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td><input type="text" class="b2" name="name" size="15" maxlength="64" value="<?php echo $name; ?>"></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td><input type="text" class="b2" name="lastname" size="15" maxlength="64"
                       value="<?php echo $lastname; ?>"></td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td><input type="text" class="b2" name="patronymic" size="15" maxlength="64"
                       value="<?php echo $patronymic; ?>"></td>
        </tr>
        <tr>
            <td>Дата рождения:</td>
            <td><input type="date" class="b2" name="birthday" size="15" maxlength="64"
                       value="<?php echo date('Y-m-d', $birthday); ?>"></td>
        </tr>
        </tbody>
    </table>
    <input type="submit" class="b2" name="change_button" value="Изменить">
    <br>
    <br>
    <?php
    if (isset($_POST['change_button'])) {
        if (strcmp($_POST['login'], "") == 0) {
            print("Введите логин");
        } elseif (strcmp($_POST['email'], "") == 0) {
                $message = "Введите email";
        } elseif (strcmp($_POST['name'], "") == 0) {
            print("Введите имя");
        } elseif (strcmp($_POST['lastname'], "") == 0) {
            print("Введите фамилию");
        } elseif (strcmp($_POST['birthday'], "") == 0) {
            print("Введите дату рождения");
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9\-_]+$/u", $_POST['login'])) {
            print("Логин содержит недопустимые символы");
        } elseif (!preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $_POST['email'])) {
            print("Email введён некорректно");
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z ']+$/u", $_POST['name'])) {
            print("Имя содержит недопустимые символы");
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z ']+$/u", $_POST['lastname'])) {
            print("Фамилия содержит недопустимые символы");
        } elseif (isset($_POST["patronymic"]) and !preg_match("/^[а-яА-ЯёЁa-zA-Z ']*$/u", $_POST['patronymic'])) {
            print("Отчество содержит недопустимые символы");
        } elseif (strtotime($_POST["birthday"]) === false) {
            print("Некорректно заданна дата рождения");
        } elseif (strtotime($_POST["birthday"]) >= time()) {
            print("Некорректно заданна дата рождения");
        } else {
            $result = change_user_info($db, $_SESSION["nickname"], $nickname, $email, $name, $lastname, $patronymic, $birthday);
            if ($result) {
                if (strcmp($_SESSION["nickname"], $nickname) != 0) {
                    $_SESSION["nickname"] = $nickname;
                }
                print("Данные успешно изменены");
            }
        }
    }
    mysqli_close($db);
    ?>
</form>
