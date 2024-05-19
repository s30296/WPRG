<?php
$ip = $_SERVER['REMOTE_ADDR'];

$lista = file("ip.txt");

if (in_array($ip, $lista)) {
    require 'test.html';
} else {
    require 'xyz.html';
}
?>