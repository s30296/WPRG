<?php
$plik = 'licznik.txt';
if (!file_exists($plik)) {
    file_put_contents($plik, '1');
}

$val = file_get_contents($plik);
$val = $val + 1;
file_put_contents($plik, $val);

echo "Liczba odwiedzin strony: $val";
?>