<?php
function create($a, $b, $c, $d) {
    $table = array();
    for ($i = $a; $i <= $b; $i++) {
        for ($j = $c; $j <= $d; $j++) {
            $table[$i][] = $j;
        }
    }
    return $table;
}

$table = create(1, 5, 50, 60);
print_r($table);
?>