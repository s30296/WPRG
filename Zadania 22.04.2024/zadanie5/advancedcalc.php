<?php
if (isset($_POST['operator'])) {
    $value = $_POST['value'];
    $operator = $_POST['operator'];

    switch ($operator) {
        case "Sinus":
            echo "Sinus($value) = ", sin(deg2rad($value));
            break;
        case "Cosinus":
            echo "Cosinus($value) = ", cos(deg2rad($value));
            break;
        case "Tangens":
            echo "Tangens($value) = ", tan(deg2rad($value));
            break;
        case "BinDec":
            echo "BinDec($value) = ", bindec($value);
            break;
        case "DecBin":
            echo "DecBin($value) = ", decbin($value);
            break;
        case "DecHex":
            echo "DecHex($value) = ", dechex($value);
            break;
        case "HexDec":
            echo "HexDec($value) = ", hexdec($value);
            break;
        default:
            echo "ERROR";
            break;
    }
}
?>