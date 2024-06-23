<?php
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $pwd = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $insert_user = $conn->prepare($sql);
    $insert_user->bind_param("ssss", $username, $pwd, $email, $role);

    if ($insert_user->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Wystąpił błąd podczas rejestracji.";
    }
}
?>

<!-- Strona rejestracyjna -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Rejestracja</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Blog</h1>
    <div class="welcome-message">
        <p>Witaj, Guest!</p>
    </div>
    <nav>
        <a href="index.php">Strona Główna</a>
        <a href="create_post.php">Dodaj post</a>
        <?php
        if (isset($_SESSION['username']) && $_SESSION['role'] != 'guest') {
            echo '<a href="admin_panel.php">Panel Administracyjny</a>';
            echo '<a href="account.php">Konto</a>';
            echo '<a href="logout.php">Wyloguj</a>';
        } else {
            echo '<a href="register.php">Zarejestruj</a>';
            echo '<a href="login.php">Zaloguj</a>';
        }
        ?>
    </nav>
    <br>
    <h1>Rejestracja</h1>
</header>
<main>
    <form class="lr" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="email">Adres email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Zarejestruj się">
    </form>
</main>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>