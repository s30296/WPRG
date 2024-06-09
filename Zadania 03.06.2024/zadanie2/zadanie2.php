<?php
$host = 'localhost';
$db = 'lab12';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    echo "Blad.";
    throw new PDOException();
}

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS Person (
        Person_id INT AUTO_INCREMENT PRIMARY KEY,
        Person_firstname VARCHAR(255) NOT NULL,
        Person_secondname VARCHAR(255) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS Cars (
        Cars_id INT AUTO_INCREMENT PRIMARY KEY,
        Cars_model VARCHAR(255) NOT NULL,
        Cars_year INT NOT NULL,
        Person_id INT,
        FOREIGN KEY (Person_id) REFERENCES Person(Person_id)
    );
    ";
    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "Blad tworzenia tabeli: ";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_person'])) {
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $insert = $pdo->prepare('INSERT INTO Person (Person_firstname, Person_secondname) VALUES (?, ?)');
    $insert->execute([$firstname, $secondname]);
    header('Location: zadanie2.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_car'])) {
    $model = $_POST['model'];
    $year = $_POST['year'];
    $person_id = $_POST['person_id'];
    $insert = $pdo->prepare('INSERT INTO Cars (Cars_model, Cars_year, Person_id) VALUES (?, ?, ?)');
    $insert->execute([$model, $year, $person_id]);
    header('Location: zadanie2.php');
    exit;
}

$selectPerson = $pdo->query('SELECT * FROM Person')->fetchAll();
$selectCars = $pdo->query('SELECT Cars.*, Person.Person_firstname, Person.Person_secondname FROM Cars JOIN Person ON Cars.Person_id = Person.Person_id')->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            color: darkslategray;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], select {
            padding: 8px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: forestgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Zarzadzaj baza MySQL</h1>
    <h2>Dodaj osobe</h2>
    <form method="post">
        <input type="hidden" name="add_person" value="1">
        <label for="firstname">Imie:</label>
        <input type="text" id="firstname" name="firstname" required>
        <label for="secondname">Nazwisko:</label>
        <input type="text" id="secondname" name="secondname" required>
        <br>
        <button type="submit">Dodaj osobe</button>
    </form>

    <h2>Dodaj samochod</h2>
    <form method="post">
        <input type="hidden" name="add_car" value="1">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>
        <label for="year">Rok:</label>
        <input type="number" id="year" name="year" required>
        <label for="person_id">Wlasciciel:</label>
        <select id="person_id" name="person_id" required>
            <?php
            for ($i = 0; $i < count($selectPerson); $i++) {
                $person = $selectPerson[$i];
                echo '<option value="' . $person['Person_id'] . '">' . $person['Person_firstname'] . ' ' . $person['Person_secondname'] . '</option>';
            }
            ?>
        </select>
        <button type="submit">Dodaj samochód</button>
    </form>

    <h2>Osoby</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Imie</th>
            <th>Nazwisko</th>
        </tr>
        <?php
        for ($i = 0; $i < count($selectPerson); $i++):
            $person = $selectPerson[$i];
            ?>
            <tr>
                <td><?= $person['Person_id'] ?></td>
                <td><?= $person['Person_firstname'] ?></td>
                <td><?= $person['Person_secondname'] ?></td>
            </tr>
        <?php endfor; ?>
    </table>

    <h2>Samochody</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Model</th>
            <th>Rok</th>
            <th>Wlasciciel</th>
        </tr>
        <?php
        for ($i = 0; $i < count($selectCars); $i++) {
            $car = $selectCars[$i];
            echo "<tr>";
            echo "<td>" . $car['Cars_id'] . "</td>";
            echo "<td>" . $car['Cars_model'] . "</td>";
            echo "<td>" . $car['Cars_year'] . "</td>";
            echo "<td>" . $car['Person_firstname'] . " " . $car['Person_secondname'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>