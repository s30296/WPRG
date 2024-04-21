<?php
function ciag($x, $y, $z) {
    $sumAry = ($z * (2 * $x + ($z - 1) * $y)) / 2;
    $potega = 1;
    for ($i = 0; $i < $y; $i++) {
        $potega = $potega * $y;
    }
    $sumGeo = $x * ($potega - 1) / ($y - 1);
    echo "Suma ciagu arytmetycznego: ", $sumAry, " | Suma ciagu geometrycznego: ", $sumGeo;
}

ciag(1, 2, 3);
?>