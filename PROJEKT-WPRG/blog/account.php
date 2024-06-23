<?php
global $conn;
session_start();
include 'includes/db.php';

// Sprawdzenie czy uzytkownik jest zalogowany
if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'guest') {
    header("Location: index.php");
    exit();
}

// Zmiana nazwy uzytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_username'])) {
    $new_username = $_POST['new_username'];
    $sql_username = "UPDATE users SET username = ? WHERE id = ?";
    $update_username = $conn->prepare($sql_username);
    $update_username->bind_param("si", $new_username, $_SESSION['user_id']);

    if ($update_username->execute()) {
        $_SESSION['username'] = $new_username;
        $success_username = "Nazwa użytkownika została zmieniona.";
    } else {
        $error_username = "Wystąpił problem podczas zmiany nazwy użytkownika.";
    }
    $update_username->close();
}

// Zmiana hasla
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $sql_password = "SELECT password FROM users WHERE id = ?";
    $select_password = $conn->prepare($sql_password);
    $select_password->bind_param("i", $_SESSION['user_id']);
    $select_password->execute();
    $result = $select_password->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];

        if (password_verify($current_password, $password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update_password = "UPDATE users SET password = ? WHERE id = ?";
            $update_password = $conn->prepare($sql_update_password);
            $update_password->bind_param("si", $hashed_password, $_SESSION['user_id']);

            if ($update_password->execute()) {
                $success_password = "Hasło zostało zmienione.";
            } else {
                $error_password = "Wystąpił problem podczas zmiany hasła.";
            }
            $update_password->close();
        } else {
            $error_password = "Podane obecne hasło jest nieprawidłowe.";
        }
    }
    $select_password->close();
}

// Zmiana adresu email
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_email'])) {
    $new_email = $_POST['new_email'];
    $sql_email = "UPDATE users SET email = ? WHERE id = ?";
    $update_email = $conn->prepare($sql_email);
    $update_email->bind_param("si", $new_email, $_SESSION['user_id']);

    if ($update_email->execute()) {
        $_SESSION['email'] = $new_email;
        $success_email = "Adres email został zmieniony.";
    } else {
        $error_email = "Wystąpił problem podczas zmiany adresu email.";
    }
    $update_email->close();
}

// Usuwanie konta uzytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // Usuniecie komentarzy uzytkownika
    $sql_comments = "DELETE FROM comments WHERE user_id = ?";
    $delete_comments = $conn->prepare($sql_comments);
    $delete_comments->bind_param("i", $_SESSION['user_id']);
    $delete_comments->execute();
    $delete_comments->close();

    // Usuniecie postow uzytkownika i komentarzy
    $sql_posts = "SELECT id FROM posts WHERE author_id = ?";
    $select_posts = $conn->prepare($sql_posts);
    $select_posts->bind_param("i", $_SESSION['user_id']);
    $select_posts->execute();
    $result_posts = $select_posts->get_result();

    while ($row_post = $result_posts->fetch_assoc()) {
        $post_id = $row_post['id'];

        // Usuniecie komentarzy do postów
        $sql_post_comments = "DELETE FROM comments WHERE post_id = ?";
        $delete_post_comments = $conn->prepare($sql_post_comments);
        $delete_post_comments->bind_param("i", $post_id);
        $delete_post_comments->execute();
        $delete_post_comments->close();

        // Usuniecie posta
        $sql_delete_post = "DELETE FROM posts WHERE id = ?";
        $delete_post = $conn->prepare($sql_delete_post);
        $delete_post->bind_param("i", $post_id);
        $delete_post->execute();
        $delete_post->close();
    }
    $select_posts->close();

    // Usuniecie uzytkownika
    $sql_user = "DELETE FROM users WHERE id = ?";
    $delete_user = $conn->prepare($sql_user);
    $delete_user->bind_param("i", $_SESSION['user_id']);

    if ($delete_user->execute()) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        $error_delete = "Wystąpił problem podczas usuwania konta.";
    }
    $delete_user->close();
}

$current_username = $_SESSION['username'];
$current_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

?>

<!--Konto-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Zarządzanie kontem</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1>Konto</h1>
</header>
<main class="ac">
    <!--Zmiana nazwy uzytkownika-->
    <h2>Zmień nazwę użytkownika</h2>
    <form action="account.php" method="post">
        <label for="new_username">Nowa nazwa użytkownika:</label><br>
        <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($current_username); ?>" required><br>
        <button type="submit" name="change_username">Zmień nazwę użytkownika</button>
    </form>
    <?php
    if (isset($success_username)) {
        echo '<p class="success">' . $success_username . '</p>';
    } elseif (isset($error_username)) {
        echo '<p class="error">' . $error_username . '</p>';
    }
    ?>

    <!--Zmiana hasla uzytkownika-->
    <h2>Zmień hasło</h2>
    <form action="account.php" method="post">
        <label for="current_password">Obecne hasło:</label><br>
        <input type="password" id="current_password" name="current_password" required><br>
        <label for="new_password">Nowe hasło:</label><br>
        <input type="password" id="new_password" name="new_password" required><br>
        <button type="submit" name="change_password">Zmień hasło</button>
    </form>
    <?php
    if (isset($success_password)) {
        echo '<p class="success">' . $success_password . '</p>';
    } elseif (isset($error_password)) {
        echo '<p class="error">' . $error_password . '</p>';
    }
    ?>

    <!--Zmiana adresu email uzytkownika-->
    <h2>Zmień adres email</h2>
    <form action="account.php" method="post">
        <label for="new_email">Nowy adres email:</label><br>
        <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($current_email); ?>" required><br>
        <button type="submit" name="change_email">Zmień adres email</button>
    </form>
    <?php
    if (isset($success_email)) {
        echo '<p class="success">' . $success_email . '</p>';
    } elseif (isset($error_email)) {
        echo '<p class="error">' . $error_email . '</p>';
    }
    ?>

    <!--Usuniecie konta uzytkownika-->
    <h2>Usuń konto</h2>
    <form action="account.php" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć swoje konto? Tej operacji nie można cofnąć.')">
        <button type="submit" name="delete_account">Usuń konto</button>
    </form>
    <?php
    if (isset($error_delete)) {
        echo '<p class="error">' . $error_delete . '</p>';
    }
    ?>
</main>
<br>
<br>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>