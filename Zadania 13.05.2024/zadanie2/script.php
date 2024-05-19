<?php
function katalog($sciezka, $katalog, $operacja = "odczyt") {
    if ($sciezka[strlen($sciezka) - 1] !== '/') {
        $sciezka = $sciezka . '/';
    }

    if ($operacja === "read") {
        if (is_dir($sciezka . $katalog)) {
            $zawartosc = scandir($sciezka . $katalog);
            echo "Zawartosc katalogu $katalog:<br>";
            $liczba = count($zawartosc);
            for ($i = 0; $i < $liczba; $i++) {
                $element = $zawartosc[$i];
                if ($element !== '.' && $element !== '..') {
                    echo "$element<br>";
                }
            }
        } else {
            echo "Katalog $katalog nie istnieje.";
        }
    } else if ($operacja === "delete") {
        if (is_dir($sciezka . $katalog)) {
            $zawartosc = scandir($sciezka . $katalog);
            if (count($zawartosc) == 2) {
                if (rmdir($sciezka . $katalog)) {
                    echo "Usunieto katalog $katalog.";
                } else {
                    echo "Nie usunieto $katalog.";
                }
            } else {
                echo "Katalog $katalog nie jest pusty, nie mozna usunac.";
            }
        } else {
            echo "Katalog $katalog nie istnieje.";
        }
    } else if ($operacja === "create") {
        if (!is_dir($sciezka . $katalog)) {
            if (mkdir($sciezka . $katalog)) {
                echo "Stworzono katalog $katalog.";
            } else {
                echo "Nie stworzono $katalog.";
            }
        } else {
            echo "Katalog $katalog juz istnieje.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sciezka = $_POST["sciezka"];
    $katalog = $_POST["katalog"];
    $operacja = $_POST["operacja"];
    katalog($sciezka, $katalog, $operacja);
}
?>