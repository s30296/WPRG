<?php
function matrix($matrix1, $matrix2) {
    $rowM1 = count($matrix1);
    $colM1 = count($matrix1[0]);
    $rowM2 = count($matrix2);
    $colM2 = count($matrix2[0]);
    if ($colM1 != $rowM2) {
        echo "Nie istnieje";
        return 0;
    }
    for ($i = 0; $i < $rowM1; $i++) {
        for ($j = 0; $j < $colM2; $j++) {
            $res[$i][$j] = 0;
            for ($k = 0; $k < $colM1; $k++) {
                $res[$i][$j] = $res[$i][$j] + $matrix1[$i][$k] * $matrix2[$k][$j];
            }
        }
    }
    for ($i = 0; $i < $rowM1; $i++) {
        for ($j = 0; $j < $colM2; $j++) {
            echo $res[$i][$j], " ";
        }
        echo "\n";
    }
}

echo "Macierz 1 * Macierz 2 =\n";
matrix([[1, 2], [3, 4], [5, 6]], [[7, 8], [9, 10]]);
?>