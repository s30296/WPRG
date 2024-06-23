<?php
// Wylogowanie się (zamkniecie sesji i usuniecie ciasteczek)
session_start();
$_SESSION = array();
session_destroy();
setcookie('username', '', time() - 3600, '/');
setcookie('user_id', '', time() - 3600, '/');
setcookie('role', '', time() - 3600, '/');
header("Location: login.php");
exit();
?>