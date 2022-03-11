<?php
// Функция для показа подходящей шапки сайта
function show_header()
{
    if (isset($_COOKIE[session_name()]) and strcmp($_COOKIE[session_name()], "") != 0) {
        session_start();
        if ($_SESSION["type"] == "User") {
            include("header_user.php");
        } elseif ($_SESSION["type"] == "Admin") {
            include("header_admin.php");
        } else {
            include("header_unsigned.php");
        }
    } else {
        include("header_unsigned.php");
    }
}

// Функция для показа настроек сортировки
// Проверка перед показом результата "if (isset($_GET["show_button"]))"
// В запросе к БД используйте $_GET["order"] и $_GET["desc"]
// $orders - это словарь,
// где ключём является столбец, по которому необходимо провести сортировку,
// а значением - видимое название соответсвующего пункта select
function show_sort_bar($orders)
{
    $desc = "";
    if (isset($_GET["desc"]) and strcmp($_GET["order"], "on")) {
        $desc = 'checked="checked"';
    }
    $selected = "";
    if (isset($_GET["order"])) {
        $selected = $_GET["order"];
    }
    ?>
    <form method="get">
        <table class="sort_bar">
            <tbody>
            <tr>
                <td>Сортировать по</td>
                <td>
                    <select name="order">
                        <?php
                        foreach ($orders as $key => $value) {
                            if (strcmp($selected, $key) == 0) {
                                echo "<option selected='selected' value=$key > $value</option>";
                            } else {
                                echo "<option value=$key > $value</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>В обратном порядке</td>
                <td><input type="checkbox" name="desc"<?php echo $desc; ?>></td>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="submit" class="b2" name="show_button" value="Показать"></td>
            </tr>
            </tbody>
        </table>
    </form>
    <br>
    <?php
}

?>