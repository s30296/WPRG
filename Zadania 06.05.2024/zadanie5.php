<?php
echo "Podaj wartosc: ";
$val = readline("");
$num = 0;
$przecinek = false;

for ($i = 0; $i < strlen($val); $i++) {
    if ($przecinek) {
        $num = $num + 1;
    }
    if ($val[$i] == '.') {
        $przecinek = true;
    }
}

echo "Ilosc cyfr po przecinku: ", $num;
?>