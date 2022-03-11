<?php
require_once("templates.php");
show_header();

require_once("db_authorization.php");
$db = connect_db("User") or die();
$info = get_user_info($db, $_SESSION["nickname"]);
mysqli_close($db);
if ($info) {
    ?>
    <h2>Информация о пользователе</h2>
    <table class="show_table">
        <tbody>
        <tr>
            <td>Логин:</td>
            <td><?php echo $info["nickname"]; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $info["email"]; ?></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td><?php echo $info["name"]; ?></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td><?php echo $info["lastname"]; ?></td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td><?php echo $info["patronymic"]; ?></td>
        </tr>
        <tr>
            <td>Дата рождения:</td>
            <td><?php echo $info["birthday"]; ?></td>
        </tr>
        </tbody>
    </table>
    <?php
}
?>