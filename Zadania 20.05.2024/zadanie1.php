<?php
$wartosc = 0;
$wartoscMax = 5;
$info = '';

if (isset($_COOKIE['odwiedziny'])) {
    $wartosc = (int)$_COOKIE['odwiedziny'];
}

$wartosc = $wartosc + 1;

setcookie('odwiedziny', $wartosc, time() + (86400 * 30));

if ($wartosc >= $wartoscMax) {
    $info = "Odwidziles ta strone wiecej niz $wartoscMax razy.";
}

if (isset($_POST['reset'])) {
    setcookie('odwiedziny', '', time() - 3600);
    header("Location: zadanie1.php");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 20px;
        }
        .container {
            display: inline-block;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .message {
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <p>Liczba odwiedzin: <?php echo $wartosc; ?></p>
    <?php if ($info): ?>
        <p class="message"><?php echo $info; ?></p>
    <?php endif; ?>
    <form method="post">
        <button type="submit" name="reset">Resetuj licznik odwiedzin</button>
    </form>
</div>
</body>
</html>