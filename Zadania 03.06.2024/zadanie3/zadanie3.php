<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "lab12";

$mysqli = new mysqli($host, $user, $pass, $db);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$mysqli->query($sql);

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hash_pass')";

    if ($mysqli->query($sql) === TRUE) {
        $msg = "Zarejestrowano.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadanie 3</title>
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
        form {
            margin-top: 30px;
        }
        form input[type="text"], form input[type="email"], form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form input[type="submit"] {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
        }
        form input[type="submit"]:hover {
            background-color: forestgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Formularz rejestracyjny</h1>
    <form method="post" action="zadanie3.php">
        <h2>First Name</h2>
        <input type="text" name="first_name" required>
        <h2>Last Name</h2>
        <input type="text" name="last_name" required>
        <h2>Email</h2>
        <input type="email" name="email" required>
        <h2>Password</h2>
        <input type="password" name="password" required>
        <br><br>
        <input type="submit" value="Zarejestruj">
    </form>
    <?php echo "<p>$msg</p>"; ?>
</div>
</body>
</html>