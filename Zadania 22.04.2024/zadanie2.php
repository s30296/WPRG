<?php
function swap($table, $n) {
    if ($n < 0 or $n >= count($table)) {
        echo "BLAD";
        return 0;
    }
    $table[$n] = '$';
    return $table;
}

$table = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
print_r(swap($table, 3));
?>