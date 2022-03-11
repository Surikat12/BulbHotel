<?php
require_once("templates.php");
show_header();

session_start();
$nickname = $_SESSION["nickname"];
if (isset($_POST['login'])) {
    $nickname = $_POST['login'];
}
?>
<h2>Введите новую информацию</h2>
<form class="short_form" method="post">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Логин:</td>
            <td><input type="text" class="b2" name="login" size="15" maxlength="64"
                       value="<?php echo $nickname; ?>"></td>
        </tr>
        </tbody>
    </table>
    <br>
    <input type="submit" class="b2" name="change_button" value="Изменить">
    <br>
    <br>
    <?php
    if (isset($_POST['change_button'])) {
        if (strcmp($nickname, "") == 0) {
            print("Введите логин");
        } elseif (!preg_match("/^[а-яА-ЯёЁa-zA-Z0-9\-_]+$/u", $nickname)) {
            print("Логин содержит недопустимые символы");
        } else {
            require_once("db_authorization.php");
            $db = connect_db("Admin") or die();
            $result = change_admin_info($db, $_SESSION["nickname"], $nickname);
            mysqli_close($db);
            if ($result) {
                if (strcmp($_SESSION["nickname"], $nickname) != 0) {
                    $_SESSION["nickname"] = $nickname;
                }
                print("Данные успешно изменены");
            }
        }
    }
    ?>
</form>
