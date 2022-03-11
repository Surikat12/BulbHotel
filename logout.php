<?php
session_start();
setcookie(session_name(), "");
$_SESSION["type"] = "Unsigned";
unset($_SESSION["nickname"]);
header("Location: main.php");
exit;
?>