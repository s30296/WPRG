<?php
// Usuwanie posta
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id'])) {
        include 'includes/db.php';

        $post_id = $_POST['post_id'];
        $sql_comments = "DELETE FROM comments WHERE post_id = ?";
        $delete_comments = $conn->prepare($sql_comments);
        $delete_comments->bind_param("i", $post_id);
        $delete_comments->execute();
        $sql_delete_post = "DELETE FROM posts WHERE id = ?";
        $delete_post = $conn->prepare($sql_delete_post);
        $delete_post->bind_param("i", $post_id);

        if ($delete_post->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Wystąpił błąd podczas usuwania wpisu.";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>