<?php
global $conn;
include 'includes/db.php';
session_start();

class Action {
    function canEdit($user_id, $comment) {
        if ($_SESSION['role'] == 'guest') {
            return false;
        }
        return $user_id == $comment['user_id'] || $_SESSION['role'] == 'admin';
    }
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT posts.*, users.username AS author_username, users.email AS author_email FROM posts JOIN users ON posts.author_id = users.id WHERE posts.id = ?";
    $select_post = $conn->prepare($sql);;
    $select_post = $conn->prepare($sql);
    $select_post->bind_param("i", $post_id);
    $select_post->execute();
    $result = $select_post->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Nie znaleziono wpisu.";
        exit();
    }

    $sql_comments = "SELECT comments.*, users.username, users.role, users.email AS commenter_email FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at DESC";
    $select_comments = $conn->prepare($sql_comments);
    $select_comments->bind_param("i", $post_id);
    $select_comments->execute();
    $result_comments = $select_comments->get_result();
    $comments = $result_comments->fetch_all(MYSQLI_ASSOC); // Stworzenie tablicy asocjacyjnej do zczytania informacji o komentarzu

} else {
    echo "Nie podano ID wpisu.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_comment_id'])) {
    $comment_id = $_POST['edit_comment_id'];
    $content = $_POST['edit_content'];
    $sql_update = "UPDATE comments SET content = ?, edited_at = NOW() WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $content, $comment_id);

    if ($stmt_update->execute()) {
        header("Location: post.php?id=$post_id");
        exit();
    } else {
        echo "Wystąpił problem podczas edytowania komentarza.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_comment_id'])) {
    $comment_id = $_POST['delete_comment_id'];
    $sql_delete = "DELETE FROM comments WHERE id = ?";
    $delete_comment = $conn->prepare($sql_delete);
    $delete_comment->bind_param("i", $comment_id);

    if ($delete_comment->execute()) {
        header("Location: post.php?id=$post_id");
        exit();
    } else {
        echo "Wystąpił problem podczas usuwania komentarza.";
    }
}

// Nastepny i poprzedni post
$sql_previous = "SELECT id FROM posts WHERE id < ? ORDER BY id DESC LIMIT 1";
$select_previous = $conn->prepare($sql_previous);
$select_previous->bind_param("i", $post_id);
$select_previous->execute();
$result_previous = $select_previous->get_result();
$previous_post = $result_previous->fetch_assoc();

$sql_next = "SELECT id FROM posts WHERE id > ? ORDER BY id ASC LIMIT 1";
$select_next = $conn->prepare($sql_next);
$select_next->bind_param("i", $post_id);
$select_next->execute();
$result_next = $select_next->get_result();
$next_post = $result_next->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <?php include 'includes/header.php';?>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
</header>
<main>
    <!-- Szczegóły wpisu -->
    <article>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <br>
        <?php if ($post['image']) { ?>
            <img src="images/<?php echo htmlspecialchars($post['image']); ?>" alt="Obrazek do wpisu">
        <?php } ?>
        <p>Autor: <a href="mailto:<?php echo htmlspecialchars($post['author_email']); ?>"><?php echo htmlspecialchars($post['author_username']); ?></a>,
            Opublikowano: <?php echo $post['created_at'];?>
            <?php if ($post['edited_at']) { ?>
            (Edytowany: <?php echo $post['edited_at']; ?>)</p>
    <?php } ?>

        <?php
        if(isset($_SESSION['username']) && ($_SESSION['user_id'] == $post['author_id'] || $_SESSION['role'] == 'admin') && $_SESSION['role'] != 'guest') {
            ?>
            <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edytuj</a>
            <?php
        }
        ?>
    </article>

    <!-- Sekcja komentarzy -->
    <section>
        <h3>Komentarze</h3>
        <?php if(isset($_SESSION['username'])) { ?>
            <form action="add_comment.php" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <textarea name="content" required></textarea><br>
                <button type="submit">Dodaj komentarz</button>
            </form>
        <?php } else { ?>
            <p>Musisz być zalogowany, aby dodać komentarz.</p>
        <?php } ?>

        <?php if (!empty($comments)) {
            foreach ($comments as $comment) { ?>
                <div class="comment">
                    <p>
                        <a href="mailto:<?php echo htmlspecialchars($comment['commenter_email']); ?>"><?php echo htmlspecialchars($comment['username']); ?></a>
                        (<?php
                        if ($comment['role'] == 'admin') {
                            echo 'Administrator';
                        } elseif ($comment['role'] == 'guest') {
                            echo 'Gość';
                        } else {
                            echo "Użytkownik";
                        }
                        ?>),
                        <?php echo $comment['created_at']; ?>
                        <?php if ($comment['edited_at']) { ?>
                            <span>(Edytowany: <?php echo $comment['edited_at']; ?>)</span>
                        <?php } ?>
                    </p>
                    <div class="comment-content <?php
                    $action = new Action();
                    if ($action->canEdit($_SESSION['user_id'], $comment)) {
                        echo 'edit-mode';
                    } else {
                        echo '';
                    }
                    ?>">
                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <?php
                        if ($action->canEdit($_SESSION['user_id'], $comment)) { ?>
                            <div class="comment-actions">
                                <!-- Edycja komentarza -->
                                <form action="post.php?id=<?php echo $post['id']; ?>" method="POST" class="edit-controls">
                                    <input type="hidden" name="edit_comment_id" value="<?php echo $comment['id']; ?>">
                                    <textarea name="edit_content"><?php echo htmlspecialchars($comment['content']); ?></textarea>
                                    <br>
                                    <button type="submit">Zapisz zmiany</button>
                                </form>
                                <!-- Usuniecie komentarza -->
                                <form action="post.php?id=<?php echo $post['id']; ?>" method="POST" class="edit-controls">
                                    <button type="submit" name="delete_comment_id" value="<?php echo $comment['id']; ?>" onclick="return confirm('Czy na pewno chcesz usunąć ten komentarz?');">Usuń komentarz</button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else {
            echo "Brak komentarzy.";
        } ?>

        <!-- Nastepny-poprzedni post -->
        <div class="post-navigation">
            <?php if ($previous_post) { ?>
                <a href="post.php?id=<?php echo $previous_post['id']; ?>">Poprzedni post</a>
            <?php } ?>
            <?php if ($next_post) { ?>
                <a href="post.php?id=<?php echo $next_post['id']; ?>">Następny post</a>
            <?php } ?>
        </div>
    </section>
</main>
<br>
<br>
<footer>
    <?php include 'includes/footer.php';?>
</footer>
</body>
</html>