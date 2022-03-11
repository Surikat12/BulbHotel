<?php
require_once("db_interaction.php");

// Функция для получения списка доступных комнат на заданный период времени
function get_suitable_rooms($link, $start_date, $end_date)
{
    $start_date = sql_date($start_date);
    $end_date = sql_date($end_date);
    $query = "SELECT DISTINCT number FROM Rooms
              WHERE number NOT IN (
                  SELECT DISTINCT room_number FROM Reservations
                  WHERE start_date <= '$end_date' AND end_date >= '$start_date')";
    $result = mysqli_query($link, $query);
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $rooms = [];
        foreach ($rows as $row) {
            $rooms[] = $row["number"];
        }
        return $rooms;
    } else {
        print("Не удалось получить список комнат");
    }
}

// Проверяет, свободен ли номер комнаты
function room_number_is_free($link, $number)
{
    $query = "SELECT number FROM Rooms WHERE number = '$number'";
    $result = mysqli_query($link, $query);
    if ($result) {
        if (count(mysqli_fetch_all($result, MYSQLI_ASSOC)) != 0) {
            return false;
        }
        return true;
    } else {
        print("Ошибка: не удалось проверить занятость логина");
        return false;
    }
}

// Функция для получения списка комнат, забронированных пользователем
function get_user_rooms($link, $nickname, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT id, room_number, DATE_FORMAT(start_date, '%d.%m.%Y') AS start_date,
              DATE_FORMAT(end_date, '%d.%m.%Y') AS end_date
              FROM Reservations
              WHERE nickname = '$nickname'
              ORDER BY $order $desc";
    $result = mysqli_query($link, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Записать в БД информацию о бронировании комнаты
function book_room($link, $nickname, $room_number, $start_date, $end_date)
{
    $start_date = sql_date($start_date);
    $end_date = sql_date($end_date);
    $query = "INSERT INTO Reservations(nickname, room_number, start_date, end_date)
              VALUES('$nickname', $room_number, '$start_date', '$end_date')";
    $result = mysqli_query($link, $query);
    if ($result) {
        $query = "SELECT id FROM Reservations
                  WHERE nickname = '$nickname' AND room_number = '$room_number' AND
                    start_date = '$start_date' AND end_date = '$end_date'";
        $result = mysqli_query($link, $query);
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0]["id"];
        } else {
            print("Ошибка: не удалось получить ID брони");
            return false;
        }
    } else {
        print("Ошибка: Не удалось забронировать комнату");
        return false;
    }


}

// Функция для получения всех комнат
function get_rooms($link, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT number FROM Rooms
              ORDER BY $order $desc";
    $rows = mysqli_query($link, $query);
    if ($rows) {
        $rooms = [];
        foreach ($rows as $row) {
            $rooms[] = $row["number"];
        }
        return $rooms;
    } else {
        print("Ошибка: не удалось получить список комнат");
        return false;
    }
}

// Функция для добавления новой комнаты
function add_room($link, $number)
{
    $query = "INSERT INTO Rooms VALUES($number)";
    $result = mysqli_query($link, $query);
    if ($result == false) {
        print("Ошибка: Не удалось добавить комнату");
        return false;
    }
    return true;
}

// Функция для удаления комнаты
function delete_room($link, $number)
{
    $query = "DELETE FROM Rooms WHERE number = $number";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось удалить комнату");
        return false;
    }
}

// Функция для получения всех броней
function get_reservations($link, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT id, nickname, room_number, DATE_FORMAT(start_date, '%d.%m.%Y') as start_date,
                     DATE_FORMAT(end_date, '%d.%m.%Y') as end_date
                     FROM Reservations
                     ORDER BY $order $desc";
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print("Ошибка: не удалось получить список броней");
        return false;
    }
}

// Функция для удаления брони
function delete_reservation($link, $id)
{
    $query = "DELETE FROM Reservations WHERE id = $id";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось добавить запись в БД");
        return false;
    }
}