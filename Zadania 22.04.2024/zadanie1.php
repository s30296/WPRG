<?php
$table = array(
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallin",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valetta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw"
);

$x = array_keys($table);
$val = array_values($table);
$length = count($table);

for ($i = 0; $i < $length - 1; $i++) {
    for ($j = $i + 1; $j < $length; $j++) {
        if ($val[$i] > $val[$j]) {
            $temp = $val[$i];
            $val[$i] = $val[$j];
            $val[$j] = $temp;
            $temp = $x[$i];
            $x[$i] = $x[$j];
            $x[$j] = $temp;
        }
    }
}

$i = 0;
while ($i < $length) {
    $country = $x[$i];
    $capital = $table[$country];
    echo "The capital of $country is $capital\n";
    $i++;
}
?>