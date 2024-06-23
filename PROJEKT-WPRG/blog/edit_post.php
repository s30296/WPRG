<?php
global $conn;
session_start();

if (isset($_GET['id']) && $_SESSION['role'] != 'guest') {
    include 'includes/db.php';

    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = ?";
    $select_post = $conn->prepare($sql);
    $select_post->bind_param("i", $post_id);
    $select_post->execute();
    $result = $select_post->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();

        if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] != $post['author_id'] && $_SESSION['role'] != 'admin')) {
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!--Edytowanie posta-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Edytuj post</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1>Edytuj post</h1>
</header>
<main>
    <form action="update_post.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>"><br>
        <label for="content">Treść:</label><br>
        <textarea id="content" name="content"><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        <label for="image">Obrazek:</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <input type="submit" value="Zapisz zmiany">
        <button id="delete" onclick="return confirm('Czy na pewno chcesz usunąć ten wpis?');" formaction="delete_post.php" formmethod="POST" name="delete_post">Usuń wpis</button>
        <button type="submit">Anuluj</button>
    </form>

</main>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>