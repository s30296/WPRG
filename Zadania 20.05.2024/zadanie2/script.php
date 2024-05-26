<?php
if (isset($_COOKIE['zaglosowano'])) {
    echo "<div class='container'><p>Juz zaglosowales.</p></div>";
} else {
    if (isset($_POST['glos'])) {
        $glos = $_POST['glos'];
        $plik = 'glosy.txt';

        $glosy = [];
        if (file_exists($plik)) {
            $linie = file($plik, FILE_IGNORE_NEW_LINES);
            $liczbaLinii = count($linie);
            for ($j = 0; $j < $liczbaLinii; $j++) {
                $linia = $linie[$j];
                list($opcja, $liczbaGlosow) = explode(':', $linia);
                $glosy[$opcja] = (int)$liczbaGlosow;
            }
        } else {
            $glosy = ['kot' => 0, 'pies' => 0, 'wieloryb' => 0, 'lis' => 0];
        }

        if (isset($glosy[$glos])) {
            $glosy[$glos]++;
        }

        $plikZapisz = fopen($plik, 'w');
        $opcje = array_keys($glosy);
        $liczbaOpcji = count($opcje);
        for ($i = 0; $i < $liczbaOpcji; $i++) {
            $opcja = $opcje[$i];
            $liczbaGlosow = $glosy[$opcja];
            fwrite($plikZapisz, "$opcja:$liczbaGlosow\n");
        }
        fclose($plikZapisz);
        setcookie('zaglosowano', '1', time() + (86400 * 30));

        $wyniki = "<div class='container'><p>Wyniki glosowania:</p>";
        $wyniki .= "<ul>";
        for ($i = 0; $i < $liczbaOpcji; $i++) {
            $opcja = $opcje[$i];
            $liczbaGlosow = $glosy[$opcja];
            $wyniki .= "<li>$opcja: $liczbaGlosow</li>";
        }
        $wyniki .= "</ul></div>";
        echo $wyniki;
    } else {
        echo "<div class='container'><p>Wybierz opcje by zaglosowac.</p></div>";
    }
}
?>