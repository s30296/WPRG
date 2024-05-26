<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $filename = 'dane.txt';
        $file = fopen($filename, 'r');

        while (($line = fgets($file)) !== false) {
            $data = explode('|', $line);

            if (trim($data[2]) === $email && trim($data[3]) === $password) {
                echo "Zalogowano jako $data[0] $data[1]";
                break;
            }
        }
    } else {
        echo "Nieporawny email/haslo";
    }
}
?>