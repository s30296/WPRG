<?php
echo "Podaj wartosc: ";
$val = readline("");
$text = preg_replace('/[\/:*?"<>|+\-.]/', '', $val);

echo "Ciag bez znakow: ", $text;
?>