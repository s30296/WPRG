<?php
$plik = file("adres.txt");

for ($i = 0; $i < count($plik); $i++) {
    $linia = $plik[$i];
    $dane = explode(";", $linia);

    if (count($dane) == 2) {
        $adres = trim($dane[0]);
        $opis = trim($dane[1]);
        echo "$opis: $adres\n";
    }
}
?>