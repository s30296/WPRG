<?php
function liczbaPierwsza($x) {
    if ($x <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($x); $i++) {
        if ($x % $i == 0) {
            return false;
        }
    }
    return true;
}

function start($x, $y) {
    for ($i = $x; $i <= $y; $i++) {
        if (liczbaPierwsza($i)) {
            echo $i, " ";
        }
    }
}

echo "Liczby pierwsze: ", start(1, 100);
?>