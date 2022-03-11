<?php
require_once("templates.php");
show_header();

$options = array("nickname" => "Логин");
show_sort_bar($options);
if (isset($_GET["show_button"])) {
    session_start();
    require_once("db_authorization.php");
    $db = connect_db("Admin") or die();
    $admins = get_admins($db, $_GET["order"], $_GET["desc"]);
    mysqli_close($db);
    if ($admins === false) {
        die();
    }
    if (count($admins) == 0) {
        print("Администраторов нет");
    } else {
        ?>
        <h2>Администраторы</h2>
        <table class="show_table">
            <thead>
            <tr>
                <td>Логин</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($admins as $admin) {
                echo "<tr><td>" . $admin;
                if (strcmp($_SESSION["nickname"], $admin) == 0) {
                    echo " (Вы)";
                }
                echo "</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>
