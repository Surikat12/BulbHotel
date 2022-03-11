<?php
require_once("templates.php");
show_header();
session_start();
?>
<h2>Информация о пользователе</h2>
<table class="show_table">
    <tbody>
    <tr>
        <td>Логин:</td>
        <td><?php echo $_SESSION["nickname"]; ?></td>
    </tbody>
</table>