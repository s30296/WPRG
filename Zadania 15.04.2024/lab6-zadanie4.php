<?php
function suma($num) {
    while (true) {
        $res = 0;
        while ($num != 0) {
            $res += $num % 10;
            $num = ($num - ($num % 10)) / 10;
        }
        if ($res >= 10) {
            return $res;
        } else {
            $num = $res;
        }
    }
}

echo "Suma cyfr liczby: ", suma(123456789);
?>