<?php
if(isset($_GET['data_urodzenia'])) {
    $data = $_GET['data_urodzenia'];

    function dzien($data) {
        $dateTime = new DateTime($data);
        $dzien = $dateTime->format('l');
        $dzien_pol = [
            'Monday' => 'Poniedziałek',
            'Tuesday' => 'Wtorek',
            'Wednesday' => 'Środa',
            'Thursday' => 'Czwartek',
            'Friday' => 'Piątek',
            'Saturday' => 'Sobota',
            'Sunday' => 'Niedziela'
        ];
        return $dzien_pol[$dzien];
    }

    function wiek($data) {
        $dzisiaj = date('Y-m-d');
        $urodziny = new DateTime($data);
        $dzisiaj = new DateTime($dzisiaj);
        $roznica = $urodziny->diff($dzisiaj);
        return $roznica->y;
    }

    function pozostalo($data) {
        $dzisiaj = new DateTime();
        $urodziny = new DateTime($data);
        $urodziny->modify('+' . (date('Y') - $urodziny->format('Y')) . ' years');
        if ($urodziny < $dzisiaj) {
            $urodziny->modify('+1 year');
        }
        $roznica = $urodziny->diff($dzisiaj);
        return $roznica->days;
    }

    echo "Data urodzenia: " . dzien($data), "<br>";
    echo "Aktualny wiek: " . wiek($data), " lat<br>";
    echo "Ilosc dzni do kolejnych urodzin: ", pozostalo($data);
}
?>