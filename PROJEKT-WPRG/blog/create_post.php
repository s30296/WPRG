<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo 'Musisz się zalogować by móc korzystać z panelu administracyjnego';
    header("Location: login.php");
}
?>

<!--Tworzenie posta-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Utwórz post</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1>Utwórz post</h1>
</header>
<main>
    <form class="cr" action="add_post.php" method="post" enctype="multipart/form-data">
        <h2>Dodaj nowy wpis</h2>
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="content">Treść:</label><br>
        <textarea id="content" name="content" rows="4" required></textarea><br>
        <label for="image">Obrazek:</label><br>
        <input type="file" id="image" name="image"><br>
        <button type="submit">Dodaj wpis</button>
    </form>
</main>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>