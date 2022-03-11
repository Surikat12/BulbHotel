<?php
require_once("db_interaction.php");

// Функция, которая возвращает тип пользоваетля, если он правильно ввёл пароль
function login($link, $nickname, $password)
{
    // Проверяем среди пользователей
    $query = "SELECT nickname FROM Users
              WHERE nickname = '$nickname' AND password = '" . md5($password) . "'";
    $result = mysqli_query($link, $query);
    if ($result) {
        if (count(mysqli_fetch_all($result, MYSQLI_ASSOC)) > 0) {
            return ["User", ""];
        }

        // Проверяем среди администраторов
        $query = "SELECT nickname FROM Admins
                  WHERE nickname = '$nickname' AND password = '" . md5($password) . "'";
        $result = mysqli_query($link, $query);
        if ($result) {
            if (count(mysqli_fetch_all($result, MYSQLI_ASSOC)) > 0) {
                return ["Admin", ""];
            }
            return [false, "Неправильный логин или пароль"];
        } else {
            return [false, "Ошибка: не удалось проверить правильность ввода"];
        }

    } else {
        return [false, "Ошибка: не удалось проверить правильность ввода"];
    }
}

// Проверяет, свободен ли никнейм
function nickname_is_free($link, $nickname)
{
    $query = "SELECT nickname FROM Users WHERE nickname = '$nickname'
              UNION
              SELECT nickname FROM Admins WHERE nickname = '$nickname'";
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

// Проверяет, свободен ли email
function email_is_free($link, $email)
{
    $query = "SELECT email FROM Users WHERE nickname = '$email'";
    $result = mysqli_query($link, $query);
    if ($result) {
        if (count(mysqli_fetch_all($result, MYSQLI_ASSOC)) != 0) {
            return false;
        }
        return true;
    } else {
        print("Ошибка: не удалось проверить занятость email");
        return false;
    }
}

// Функция проверяет, такой ли пароль у пользователя
function password_is_correct($link, $nickname, $password)
{
    $query = "SELECT nickname FROM Users
              WHERE nickname = '$nickname' AND password = '" . md5($password) . "'
              UNION
              SELECT nickname FROM Admins
              WHERE nickname = '$nickname' AND password = '" . md5($password) . "'";
    $result = mysqli_query($link, $query);
    if ($result) {
        if (count(mysqli_fetch_all($result, MYSQLI_ASSOC)) > 0) {
            return true;
        }
        return false;
    } else {
        print("Ошибка: не удалось подтвердить правильность пароля");
        return false;
    }
}

// Функция для регистрации нового пользователя
function signin($link, $nickname, $email, $password, $name, $lastname, $patronymic, $birthday)
{
    if (!nickname_is_free($link, $nickname)) {
        return [false, "Пользователь с таким именем уже существует"];
    }
    if (!email_is_free($link, $email)) {
        return [false, "Email занят"];
    }
    $birthday = sql_date($birthday);
    $query = "INSERT INTO Users
              VALUES ('$nickname', '$email', '" . md5($password) . "', '$name', '$lastname', '$patronymic', '$birthday')";
    $result = mysqli_query($link, $query);
    if ($result) {
        return [true, ""];
    } else {
        return [false, "Ошибка: Не удалось добавить пользователя"];
    }
}

// Функция для получения информации о пользователе
function get_user_info($link, $nickname)
{
    $query = "SELECT nickname, email, name, lastname, patronymic, DATE_FORMAT(birthday, '%d.%m.%Y') as birthday
              FROM Users
              WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    } else {
        print("Ошибка: не удалось получить информацию о пользователе");
        return false;
    }
}

// Функция для смены информации о пользователе
function change_user_info($link, $nickname, $new_nickname, $new_email, $new_name, $new_lastname, $new_patronymic, $new_birthday)
{
    if ($nickname != $new_nickname and !nickname_is_free($link, $new_nickname)) {
        print("Никнейм занят");
        return false;
    }
    if (!email_is_free($link, $new_email)) {
        print("Email занят");
        return false;
    }
    $new_birthday = sql_date($new_birthday);
    $query = "UPDATE Users SET nickname='$new_nickname', email='$new_email', name='$new_name',
                 lastname='$new_lastname', patronymic='$new_patronymic', birthday='$new_birthday'
              WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось изменить информацию о пользователе");
        return false;
    }
}

// Функция для смены пароля пользователя
function change_user_password($link, $nickname, $old_password, $new_password)
{
    if (!password_is_correct($link, $nickname, md5($old_password))) {
        return false;
    }
    $query = "UPDATE Users SET password='" . md5($new_password) . "'
              WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось изменить пароль");
        return false;
    }
}

// Функция для получения информации о администраторах
function get_admins($link, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT nickname FROM Admins
              ORDER BY $order $desc";
    $result = mysqli_query($link, $query);
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $admins = [];
        foreach ($rows as $row) {
            $admins[] = $row["nickname"];
        }
        return $admins;
    } else {
        print("Ошибка: не удалось получить список администраторов");
    }
}

// Функция для регистрации нового администратора
function add_admin($link, $nickname, $password)
{
    if (!nickname_is_free($link, $nickname)) {
        print("Пользователь с таким именем уже существует");
        return false;
    }
    $query = "INSERT INTO Admins
              VALUES ('$nickname', '" . md5($password) . "')";
    $result = mysqli_query($link, $query);
    if ($result == false) {
        print("Ошибка: Не удалось добавить администратора");
        return false;
    }
    return true;
}

// Функция для удаления администратора
function delete_admin($link, $nickname)
{
    $query = "DELETE FROM Admins WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось удалить администратора");
        return false;
    }
}

function change_admin_info($link, $nickname, $new_nickname)
{
    if ($nickname != $new_nickname and !nickname_is_free($link, $new_nickname)) {
        print("Никнейм занят");
        return false;
    }
    $query = "UPDATE Admins SET nickname='$new_nickname'
              WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result == false) {
        print("Ошибка: Не удалось изменить информацию о пользователе");
        return false;
    }
    return true;
}

// Функция для смены пароля администратора
function change_admin_password($link, $nickname, $old_password, $new_password)
{
    if (!password_is_correct($link, $nickname, $old_password)) {
        print("Пароли не совпадают");
        return false;
    }
    $query = "UPDATE Admins SET password='" . md5($new_password) . "'
              WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось изменить пароль");
        return false;
    }

}

// Функция для получения информации о всех пользователях
function get_users_info($link, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT nickname, email, name, lastname, patronymic, DATE_FORMAT(birthday, '%d.%m.%Y') as birthday
              FROM Users
              ORDER BY $order $desc";
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print("Ошибка: не удалось получить информацию о пользователях");
        return false;
    }
}

// Функция для получения всех пользователей
function get_users($link, $order, $desc)
{
    $desc = ($desc) ? "DESC" : "";
    $query = "SELECT nickname FROM Users
              ORDER BY $order $desc";
    $result = mysqli_query($link, $query);
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = $row["nickname"];
        }
        return $users;
    } else {
        print("Ошибка: не удалось получить список пользователей");
        return false;
    }
}

// Функция для удаления пользователя
function delete_user($link, $nickname)
{
    $query = "DELETE FROM Users WHERE nickname = '$nickname'";
    $result = mysqli_query($link, $query);
    if ($result) {
        return true;
    } else {
        print("Ошибка: Не удалось удалить запись из БД");
        return false;
    }
}