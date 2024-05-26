<?php
session_start();
$uid = "admin";
$pwd = "admin";

if (isset($_POST['login']) && isset($_POST['password'])) {
    $uidInput = $_POST['login'];
    $pwdInput = $_POST['password'];

    if ($uidInput === $uid && $pwdInput === $pwd) {
        $_SESSION['logged'] = true;
        echo "Zalogowano.<br>";
        echo '<a href="logout.php">Wyloguj</a>';
    } else {
        echo "Bledny login/haslo.<br>";
        echo '<a href="index.html">Powrot do strony logowania</a>';
    }
} else {
    header("Location: index.html");
    exit();
}
?>