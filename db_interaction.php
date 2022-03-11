<?php
// Функция для подключения к БД
function connect_db($user_name)
{
    $link = mysqli_connect("localhost", "surikat12y", "sdYx8P8SnmC2SSsE", "surikat12y");
    if ($link == false) {
        print("Ошибка: не удалось подключиться к базе данных");
        return false;
    }
    mysqli_set_charset($link, "utf8");
    return $link;
}

// Функция преобразует дату в формат, воспринимаемый MySQL
function sql_date($date)
{
    return date("Y-m-d", $date);
}

?>