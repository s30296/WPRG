<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            color: darkslategray;
        }
        .delete {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
        }
        .delete:hover {
            background-color: forestgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Zarzadzaj tabela MySQL</h1>
    <?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'lab12';
    $mysqli = new mysqli($host, $user, $pass, $name);
    $sql = 'CREATE DATABASE IF NOT EXISTS ' . $name;
    if (mysqli_query($mysqli, $sql)) {
        echo "Baza danych $name utworzona lub juz istnieje.<br>";
    }

    $mysqli = new mysqli($host, $user, $pass, $name);
    if (isset($_POST['delete'])) {
        $drop = "DROP TABLE IF EXISTS student";
        if ($mysqli->query($drop) === TRUE) {
            echo "Tabela student usunieta.<br>";
        }
        header("Location: zadanie1.php");
        exit;
    }

    $tableExists = $mysqli->query("SHOW TABLES LIKE 'student'");
    if($tableExists && $tableExists->num_rows == 0) {
        $sqlTable = "
            CREATE TABLE IF NOT EXISTS student (
                StudentID INT PRIMARY KEY AUTO_INCREMENT,
                Firstname VARCHAR(255) NOT NULL,
                Secondname VARCHAR(255) NOT NULL,
                Salary INT NOT NULL,
                DateOfBirth DATE NOT NULL
            )";

        if ($mysqli->query($sqlTable) === TRUE) {
            echo "Tabela student utworzona lub juz istnieje.<br>";
        }
    } else {
        echo "Tabela student juz istnieje.<br>";
    }

    $mysqli->close();
    ?>
    <form method="post">
        <input type="submit" class="delete" name="delete" value="Usun tabele">
    </form>
</div>
</body>
</html>