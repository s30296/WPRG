<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'guest') {
    header("Location: index.php");
    exit();
}

global $conn;
include 'includes/db.php';

$sql = "SELECT posts.*, users.username AS author_username FROM posts LEFT JOIN users ON posts.author_id = users.id ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
$sql_posts = "SELECT * FROM posts WHERE author_id = ? ORDER BY created_at DESC";
$posts = $conn->prepare($sql_posts);
$posts->bind_param("i", $_SESSION['user_id']);
$posts->execute();
$result_posts = $posts->get_result();
$sql_comments = "SELECT comments.*, posts.title AS post_title FROM comments LEFT JOIN posts ON comments.post_id = posts.id WHERE comments.user_id = ?";
$comments = $conn->prepare($sql_comments);
$comments->bind_param("i", $_SESSION['user_id']);
$comments->execute();
$result_comments = $comments->get_result();
?>

<!--Panel Administracyjny-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Panel administracyjny</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1>Panel administracyjny</h1>
</header>
<main>
    <!--Posty danego uzytkownika-->
    <h2>Twoje posty</h2>
    <?php
    if ($result_posts->num_rows > 0) {
        while ($row_post = $result_posts->fetch_assoc()) {
            echo '<article>';
            echo '<h3><a href="post.php?id=' . $row_post['id'] . '">' . htmlspecialchars($row_post['title']) . '</a></h3>';
            echo '<a href="edit_post.php?id=' . $row_post['id'] . '">Edytuj</a><br>';
            echo '</article>';
            echo '<br>';
        }
    } else {
        echo '<p>Brak postów do wyświetlenia.</p>';
    }
    ?>

    <!--Komentarze danego uzytkownika-->
    <h2>Twoje komentarze</h2>
    <?php
    if ($result_comments->num_rows > 0) {
        while ($row_comment = $result_comments->fetch_assoc()) {
            echo '<article>';
            echo '<h3>Komentarz do posta: ' . htmlspecialchars($row_comment['post_title']) . '</h3>';
            echo '<p>' . htmlspecialchars($row_comment['content']) . '</p>';
            echo '<a href="post.php?id=' . $row_comment['post_id'] . '#comment-' . $row_comment['id'] . '">Przejdź do komentarza</a>';
            echo '</article>';
            echo '<br>';
        }
    } else {
        echo '<p>Brak komentarzy do wyświetlenia.</p>';
    }
    ?>

    <!--Panel administracyjny dla administratora-->
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h2>Wszyscy użytkownicy</h2>
        <?php
        $sql_users = "SELECT * FROM users";
        $result_users = $conn->query($sql_users);

        if ($result_users->num_rows > 0) {
            while ($row_user = $result_users->fetch_assoc()) {
                if ($row_user['role'] != 'admin') {
                    echo '<h2>' . htmlspecialchars($row_user['username']) . '</h2>';
                    $sql_posts = "SELECT * FROM posts WHERE author_id = " . $row_user['id'];
                    $result_posts = $conn->query($sql_posts);

                    echo '<h3>Posty</h3>';
                    if ($result_posts->num_rows > 0) {
                        while ($row_post = $result_posts->fetch_assoc()) {
                            echo '<article>';
                            echo '<h3><a href="post.php?id=' . $row_post['id'] . '">' . htmlspecialchars($row_post['title']) . '</a></h3>';
                            echo '<a href="edit_post.php?id=' . $row_post['id'] . '">Edytuj</a><br>';
                            echo '</article>';
                            echo '<br>';
                        }
                    } else {
                        echo '<p>Brak postów użytkownika.</p>';
                    }

                    $sql_comments_user = "SELECT comments.*, posts.title AS post_title FROM comments LEFT JOIN posts ON comments.post_id = posts.id WHERE comments.user_id = " . $row_user['id'] . " ORDER BY comments.created_at DESC";
                    $result_comments_user = $conn->query($sql_comments_user);

                    echo '<h3>Komentarze</h3>';
                    if ($result_comments_user->num_rows > 0) {
                        while ($row_comment = $result_comments_user->fetch_assoc()) {
                            echo '<article>';
                            echo '<h4>Komentarz do posta: ' . htmlspecialchars($row_comment['post_title']) . '</h4>';
                            echo '<p>' . htmlspecialchars($row_comment['content']) . '</p>';
                            echo '<a href="post.php?id=' . $row_comment['post_id'] . '#comment-' . $row_comment['id'] . '">Przejdź do komentarza</a>';
                            echo '</article>';
                            echo '<br>';
                        }
                    } else {
                        echo '<p>Brak komentarzy użytkownika.</p>';
                    }
                }
            }
        } else {
            echo '<p>Brak użytkowników do wyświetlenia.</p>';
        }
        ?>
    <?php endif; ?>
</main>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>