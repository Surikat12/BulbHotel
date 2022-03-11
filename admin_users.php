<?php
require_once("templates.php");
show_header();

$orders = array("nickname" => "Логин", "email" => "Email", "lastname" => "Фамилия", "name" => "Имя",
    "patronymic" => "Отчество", "Users.birthday" => "Дата рождения");
show_sort_bar($orders);
if (isset($_GET["show_button"])) {
    require_once("db_authorization.php");
    $db = connect_db("Admin") or die();
    $users = get_users_info($db, $_GET["order"], $_GET["desc"]);
    mysqli_close($db);
    if ($users === false) {
        die();
    }
    if (count($users) == 0) {
        print("Пользователей нет");
    } else {
        ?>
        <h2>Пользователи</h2>
        <table class="show_table">
            <thead>
            <tr>
                <td>Логин</td>
                <td>Email</td>
                <td>Фамилия</td>
                <td>Имя</td>
                <td>Отчество</td>
                <td>Дата рождения</td>
            </tr>
            </thead>
            <tbody>
            <?
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user["nickname"] . "</td>";
                echo "<td>" . $user["email"] . "</td>";
                echo "<td>" . $user["lastname"] . "</td>";
                echo "<td>" . $user["name"] . "</td>";
                echo "<td>" . $user["patronymic"] . "</td>";
                echo "<td>" . $user["birthday"] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>

