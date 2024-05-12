<?php
function sum($val) {
    $samogloski = "aeiouAEIOU";
    $num = 0;

    for ($i = 0; $i < strlen($val); $i++) {
        $x = $val[$i];
        for ($j = 0; $j < strlen($samogloski); $j++) {
            if ($x == $samogloski[$j]) {
                $num = $num + 1;
                break;
            }
        }
    }
    return $num;
}

echo "Podaj wartosc: ";
$val = readline("");
$num = sum($val);

echo "Ilosc samoglosek: ", $num;
?>