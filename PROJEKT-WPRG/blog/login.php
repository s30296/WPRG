<?php
global $conn;
session_start();

if (isset($_SESSION['username']) && $_SESSION['role'] != 'guest') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $select_user = $conn->prepare($sql);
    $select_user->bind_param("s", $username);
    $select_user->execute();
    $result = $select_user->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            setcookie('username', $username, time() + 86400, '/');
            setcookie('user_id', $row['id'], time() + 86400, '/');
            setcookie('role', $row['role'], time() + 86400, '/');
            header("Location: index.php");
            exit();
        } else {
            echo "Nieprawidłowa nazwa użytkownika lub hasło.";
        }
    } else {
        echo "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>

<!--Strona logowania-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Logowanie</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1>Logowanie</h1>
</header>
<main>
    <form class="lr" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Zaloguj się">
    </form>
</main>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>