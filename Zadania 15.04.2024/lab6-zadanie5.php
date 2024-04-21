<?php
function pangram($txt) {
    $alfabet = "abcdefghijklmnopqrstuvwxyz";
    for ($i = 0; $i < strlen($alfabet); $i++) {
        $val = $alfabet[$i];
        $res = false;
        for ($j = 0; $j < strlen($txt); $j++) {
            if ($txt[$j] == $val) {
                $res = true;
                break;
            }
        }
        if ($res == false) {
            return false;
        }
    }
    return $res;
}

echo "The quick brown fox jumps over the lazy dog. - ";
if (pangram("The quick brown fox jumps over the lazy dog.") == true) {
    echo "Jest pangramem.\n";
} else {
    echo "Nie jest pangramem\n";
}

echo "Test czy jest to pangram. - ";
if (pangram("Test czy jest to pangram.") == true) {
    echo "Jest pangramem.\n";
} else {
    echo "Nie jest pangramem.\n";
}
?>