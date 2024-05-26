<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['imie']) || empty($_POST['nazwisko']) || empty($_POST['email']) || empty($_POST['haslo'])) {
        echo "Wypelnij wszystkie elementy.";
    } else {
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $email = $_POST['email'];
        $haslo = $_POST['haslo'];

        $plik = file('dane.txt');
        $plik_count = count($plik);
        for ($i = 0; $i < $plik_count; $i++) {
            $linia = $plik[$i];
            list($zapisImie, $zapisNazwisko, $zapisEmail, $zapisHaslo) = explode('|', $linia);
            if (trim($zapisEmail) === $email) {
                echo "E-mail już istnieje.";
                exit;
            }
        }

        $file = fopen('dane.txt', 'a');
        if ($file) {
            fwrite($file, "$imie|$nazwisko|$email|$haslo\n");
            fclose($file);
            echo "Zapisano informacje.";
        } else {
            echo "Blad zapisu informacji.";
        }
    }
}
?>