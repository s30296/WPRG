<?php
session_start();
global $conn;
include 'includes/db.php';

if (isset($_COOKIE['user_id'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

// Zainicjowanie goscia
if (!isset($_SESSION['username']) && !isset($_COOKIE['user_id'])){
    $_SESSION['username'] = 'Guest';
    $_SESSION['user_id'] = '2';
    $_SESSION['role'] = 'guest';
}
?>

<!--Strona glowna-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Strona główna</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
</header>
<main class="mp">
    <?php
    $sql = "SELECT posts.*, users.username AS author_username FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <article>
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <?php if ($row['image']) { ?>
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Obrazek do wpisu">
                <?php } ?>
                <?php if (isset($row['author_username'])) { ?>
                    <p>Autor: <?php echo htmlspecialchars($row['author_username']); ?></p>
                <?php } else { ?>
                    <p>Autor: nieznany</p>
                <?php } ?>
                <a href="post.php?id=<?php echo $row['id']; ?>">Czytaj więcej</a>
            </article>
            <?php
        }
    } else {
        echo "Brak wpisów.";
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