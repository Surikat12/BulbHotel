<?php
require_once("templates.php");
show_header();

$start_date = "";
if (isset($_GET["start_date"])) {
    $start_date = $_GET["start_date"];
}
$end_date = "";
if (isset($_GET["end_date"])) {
    $end_date = $_GET["end_date"];
}

require_once("db_reservation.php");
$db = connect_db("User") or die();
?>
<h2>Бронирование номера</h2>
<form class="default_form" method="get">
    <table class="default_table">
        <tbody>
        <tr>
            <td>Дата начала:</td>
            <td><input type="date" class="b2" name="start_date" size="15" value="<?php echo $start_date; ?>"></td>
        </tr>
        <tr>
            <td>Дата конца:</td>
            <td><input type="date" class="b2" name="end_date" size="15" value="<?php echo $end_date; ?>"></td>
        </tr>
        </tbody>
    </table>
    <td><input type="submit" class="b2" name="search_button" value="Найти подходящие номера"></td>
    <br>
    <br>
    <?php
    if (isset($_GET['search_button'])) {
        if (isset($_GET["start_date"]) and isset($_GET["end_date"])) {
            if (strcmp($_GET["start_date"], "") == 0) {
                print("Введите дату начала");
                echo "</form>";
            } elseif (strcmp($_GET["end_date"], "") == 0) {
                print("Введите дату конца");
                echo "</form>";
            } elseif (strtotime($_GET["start_date"]) === false) {
                print("Некорректно заданна дата начала");
                echo "</form>";
            } elseif (strtotime($_GET["end_date"]) === false) {
                print("Некорректно заданна дата конца");
                echo "</form>";
            } elseif (strtotime($_GET["start_date"]) >= strtotime($_GET["end_date"])) {
                print("Дата конца должна быть позже даты начала");
                echo "</form>";
            } elseif (strtotime($_GET["start_date"]) <= time()) {
                print("Можно бронировать только на будущие дни");
                echo "</form>";
            } elseif (strtotime($_GET["end_date"]) <= time()) {
                print("Можно бронировать только на будущие дни");
                echo "</form>";
            } else {
                require_once("reservation_form2.php");
            }
        } else {
            print("Заполните все поля");
        }
    }

    if (isset($_POST['reservation_button'])) {
        $start_date = strtotime($_GET["start_date"]);
        $end_date = strtotime($_GET["end_date"]);
        $id = book_room($db, $_SESSION["nickname"], $_POST["rooms"], $start_date, $end_date);
        if ($id !== false) {
            print("Бронирование номера прошло успешно. Номер вашей брони - '$id'");
        }
    }
    mysqli_close($db);
    ?>
</form>
