<?php
if (isset($_POST['operator'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];

    switch ($operator) {
        case "Dodaj":
            echo "Dodaj($num1 + $num2) = ", $num1 + $num2;
            break;
        case "Odejmij":
            echo "Odejmij($num1 - $num2) = ", $num1 - $num2;
            break;
        case "Pomnoz":
            echo "Pomnóż($num1 * $num2) = ", $num1 * $num2;
            break;
        case "Podziel":
            if ($num2 != 0) {
                echo "Podziel($num1 / $num2) = ", $num1 / $num2;
            } else {
                echo "Nie mozna dzielic przez zero.";
            }
            break;
        default:
            echo "ERROR";
            break;
    }
}
?>